<?php

namespace App\Http\Controllers;

use App\Message;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\TriggerPusher;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{

    use UploadFiles;
    use TriggerPusher;

    protected $folder = '/images/messages/';

    public function sendMessage(Request $r)
    {

        $user = Auth::user();
        $photo = null;

        if ($r->file('photo')) {

            $r->validate([
                'photo' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
            ]);

            $photo = Storage::url(request()->file('photo')->store('public'));

        } else {

            $r->validate(['messageText' => 'required|min:2']);

        }

        $roomName = ($r->roomName === 'group_chat') ? $r->roomName : "$r->roomName-$r->chatId";

        $this->pushMessage([
            'message' => $this->saveMessages($r, $photo, $user),
            'room_message' => "$r->roomName-$r->chatId",
            'room_list' => $roomName
        ]);

    }

    public function lastMessagesGroup(Request $r)
    {
        return response()->json(Message::lastMessages($r->room_name, $r->chat_id, 5), 200);
    }

    public function usersTyping(Request $r)
    {
        $this->triggerPusher(
            "typing-$r->room_name-$r->chat_id",
            'userTyping',
            Auth::user()
        );
    }

    protected function saveMessages($r, $photo, $user) {

        return Message::create([
            'body' => $r->messageText,
            'user_id' => $user->id,
            $r->roomName => $r->chatId,
            'photo' => $photo
        ]);

    }

    protected function pushMessage(array $data)
    {
        if ($data['message']) {

            $this->triggerPusher($data['room_message'], 'pushMessage', [
                'message' => $data['message'],
                'user' => Auth::user()
            ]);

            $this->triggerPusher($data['room_list'], 'updateList', ['message' => $data['message']]);

            return response()->json($data['message'], 200);
        }
    }

}
