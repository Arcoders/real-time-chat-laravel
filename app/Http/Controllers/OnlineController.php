<?php

namespace App\Http\Controllers;

use App\Online;
use App\Traits\TriggerPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineController extends Controller
{
    use TriggerPusher;

    public function onlineGroupUsers(Request $request)
    {

        $user = Auth::user();
        $roomName = $request['room_name'];
        $chatId = $request['chat_id'];

        if ($user->online()->count() > 0) return;

        $this->insertOnlineGroup($user->id, $chatId, $roomName);

        $this->updateOnlineUsers($chatId, $roomName);

    }

    public function disconnectUser(Request $request)
    {
        Auth::user()->online()->delete();
        $this->updateOnlineUsers($request->chat_id, $request->room_name);
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
