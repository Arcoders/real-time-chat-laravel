<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\TriggerPusher;

class MessagesController extends Controller
{

    use TriggerPusher;

    public function sendMessageInGroup(Request $request)
    {
        $message = new Message();
        $message->body = $request->message;
        $message->user_id = Auth::user()->id;
        $message->group_id = $request->group_id;

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
        $user = Auth::user()->pluck('name', 'avatar');
        trigger_pusher('room-' . $request->group_id, 'userTyping', ['userName' => $user]);
        return response()->json($user, 200);
    }

}
