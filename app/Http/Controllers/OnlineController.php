<?php

namespace App\Http\Controllers;

use App\Online;
use App\Traits\TriggerPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineController extends Controller
{
    use TriggerPusher;

    public function onlineGroupUsers(Request $r)
    {

        $user = Auth::user();
        $roomName = $r['room_name'];
        $chatId = $r['chat_id'];

        if ($user->online()->count() > 0) return;

        $this->insertOnlineGroup($user->id, $chatId, $roomName);

        $this->updateOnlineUsers($chatId, $roomName);

    }

    public function disconnectUser(Request $r)
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

    protected function insertOnlineGroup($user, $room, $room_name)
    {
        $online = new Online();
        $online->user_id = $user;
        $online->$room_name = $room;
        $online->timelogin = time();
        $online->save();
    }


}
