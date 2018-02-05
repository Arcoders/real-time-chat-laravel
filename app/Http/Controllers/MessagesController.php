<?php

namespace App\Http\Controllers;

use App\Message;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\TriggerPusher;

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

            $photo = $this->processImage($r->file('photo'), $user->id, $this->folder, false);

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
        $count =  Message::where($r->room_name, $r->chat_id)->count();

        return Message::where($r->room_name, $r->chat_id)->with('user')->skip($count - 5)->take(5)->get();
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

        $message = new Message();
        $roomName = $r->roomName;

        $message->body = $r->messageText;
        $message->user_id = $user->id;
        $message->$roomName = $r->chatId;
        $message->photo = $photo;

        return $message;
    }

    protected function pushMessage(array $data)
    {
        if ($data['message']->save()) {

            $this->triggerPusher($data['room_message'], 'pushMessage', [
                'message' => $data['message'],
                'user' => Auth::user()
            ]);

            $this->triggerPusher($data['room_list'], 'updateList', ['message' => $data['message']]);

            return response()->json($data['message'], 200);
        }
    }

}
