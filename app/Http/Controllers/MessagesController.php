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

    public function sendMessageInGroup(Request $request)
    {

        $request->validate([
            'messageText' => 'required|min:2',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
        ]);

        $user = Auth::user();
        $photo= null;

        if ($request->file('photo')) {

            $photo = $this->processImage($request->file('photo'), $user->id, $this->folder);
        }

        $message = new Message();
        $message->body = $request->messageText;
        $message->user_id = $user->id;
        $message->group_id = $request->groupId;
        $message->photo = $photo;

        if ($message->save()) {
            $this->triggerPusher('room-' . $message->group_id, 'pushMessage', [
                'message' => $message,
                'user' => Auth::user()
            ]);
            return response()->json($message, 200);
        }
    }

    public function lastMessagesGroup(Request $request)
    {
        $count =  Message::where('group_id', $request->group_id)->count();
        return Message::where('group_id', $request->group_id)
                        ->with('user', 'group')
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
