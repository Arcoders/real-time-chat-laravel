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
    use TriggerPusher;

    public function send(Request $r)
    {
        $photo = null;

        if ($r->file('photo')) {

            $r->validate(['photo' => 'image|mimes:jpeg,jpg,png,gif|max:1500']);

            $photo = Storage::url(request()->file('photo')->store('public/messages'));

        } else {

            $r->validate(['messageText' => 'required|min:2']);

        }

        $this->pushMessage([

            'msg' => $this->saveMessages($r, $photo, Auth::user()),

            'room' => "$r->roomName-$r->chatId",

            'list' => ($r->roomName === 'group_chat') ? $r->roomName : "$r->roomName-$r->chatId"

        ]);

    }

    public function latest(Request $r)
    {
        return response()->json(Message::lastMessages($r->room_name, $r->chat_id, 5), 200);
    }

    public function typing(Request $r)
    {
        $this->triggerPusher("typing-$r->room_name-$r->chat_id", 'userTyping', Auth::user());
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
        $this->triggerPusher($data['room'], 'pushMessage', ['message' => $data['msg'], 'user' => Auth::user()]);

        $this->triggerPusher($data['list'], 'updateList', ['message' => $data['msg']]);
    }

}
