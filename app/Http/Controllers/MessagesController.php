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

        $roomName = ($r->room_name === 'group_chat') ? "$r->roomName-$r->chatId" : 'room-group';

        $this->pushMessage([
            'message' => $this->saveMessages($r, $photo, $user),
            'room_message' => "$r->roomName-$r->chatId",
            'room_list' => $roomName
        ]);

    }

    public function lastMessagesGroup(Request $request)
    {
        $count =  Message::where($request->room_name, $request->chat_id)->count();

        return Message::where($request->room_name, $request->chat_id)
                ->with('user')
                ->skip($count - 5)
                ->take(5)
                ->get();
    }

    public function usersTyping(Request $request)
    {
        $user = Auth::user();
        $data = ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar];

        $this->triggerPusher("typing-$request->room_name-$request->chat_id", 'userTyping', $data);

        return response()->json($data, 200);
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
