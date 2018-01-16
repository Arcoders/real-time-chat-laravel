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

        $message = new Message();

        $message->body = $request->messageText;
        $message->user_id = $user->id;

        if ($request->roomName === 'friend') $message->chat_id = $request->chatId;
        if ($request->roomName === 'group') $message->group_id = $request->chatId;

        $message->photo = $photo;

        if ($message->save()) {
            $this->triggerPusher('room-' . $message->group_id, 'pushMessage', [
                'message' => $message,
                'user' => $user
            ]);
            $this->triggerPusher('room-group', 'updateList', ['message' => $message]);
            return response()->json($message, 200);
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

        $this->triggerPusher('room-' . $request->group_id, 'userTyping', $data);

        return response()->json($data, 200);
    }

}
