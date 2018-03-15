<?php

namespace App\Http\Controllers;

use App\Online;
use App\Traits\TriggerPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineController extends Controller
{
    use TriggerPusher;

    public function connected(Request $r)
    {

        $user = Auth::user();

        if ($user->online()->count() > 0) return;

        Online::create(['user_id' => $user->id, $r['room_name'] => $r['chat_id']]);

        $this->updateOnlineUsers($r['chat_id'], $r['room_name']);

    }

    public function disconnect(Request $r)
    {
        Auth::user()->online()->delete();

        $this->updateOnlineUsers($r->chat_id, $r->room_name);
    }

    protected function updateOnlineUsers($chat_id, $room_name)
    {
        $this->triggerPusher(
            "online-$room_name-$chat_id",
            'onlineUsers',
            Online::where($room_name, $chat_id)->with('user')->get()->pluck('user')
        );
    }

}
