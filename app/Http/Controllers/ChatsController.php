<?php

namespace App\Http\Controllers;

use App\Message;
use App\Traits\TriggerPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    use TriggerPusher;

    public function chatsList()
    {
        return response()->json([
            'groups' => Auth::user()->groups,
            'friends' => Auth::user()->friends(true)
        ], 200);
    }

    public function sendMessage(Request $request)
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

}
