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

    public function sendMessage(Request $request)
    {

        $user = Auth::user();
        $photo= null;

        if ($request->file('photo')) {

            $request->validate([
                'photo' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
            ]);

            $photo = $this->processImage($request->file('photo'), $user->id, $this->folder, false);

        } else {

            $request->validate(['messageText' => 'required|min:2']);

        }

        if ($request->roomName === 'friend') {

            $this->pushMessage([
                'message' => $this->saveMessages($request, 'chat_id', $photo, $user),
                'room_message' => "friend-$request->chatId",
                'user' => $user,
                'room_list' => "chat-$request->chatId"
            ]);

        }

        if ($request->roomName === 'group') {

            $this->pushMessage([
                'message' => $this->saveMessages($request, 'group_id', $photo, $user),
                'room_message' => "group-$request->chatId",
                'user' => $user,
                'room_list' => "room-group"
            ]);

        }

    }

    public function lastMessagesGroup(Request $request)
    {
        $column = ($request->room_name === 'friend') ? 'chat_id' : 'group_id';

        $count =  Message::where($column, $request->chat_id)->count();
        return Message::where($column, $request->chat_id)
                        ->with('user')
                        ->skip($count - 5)
                        ->take(5)
                        ->get();
    }

    public function usersTyping(Request $request)
    {
        $user = Auth::user();
        $data = ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar];

        $room = ($request->room_name === 'friend')
            ?
            "typing-chat-$request->chat_id"
            :
            "typing-group-$request->chat_id";

        $this->triggerPusher($room, 'userTyping', $data);

        return response()->json($data, 200);
    }

    protected function saveMessages($request, $type, $photo, $user) {
        $message = new Message();

        $message->body = $request->messageText;
        $message->user_id = $user->id;
        $message->$type = $request->chatId;
        $message->photo = $photo;

        return $message;
    }


    protected function pushMessage(array $data)
    {
        if ($data['message']->save()) {

            $this->triggerPusher($data['room_message'], 'pushMessage', [
                'message' => $data['message'],
                'user' => $data['user']
            ]);

            $this->triggerPusher($data['room_list'], 'updateList', ['message' => $data['message']]);

            return response()->json($data['message'], 200);
        }
    }

}
