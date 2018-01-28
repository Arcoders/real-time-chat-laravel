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
        $column = ($room_name === 'friend') ? 'chat_id' : 'group_id';

        $room = ($room_name === 'friend') ? "onlineChat-$chat_id" : "onlineGroup-$chat_id";

        $onlineUsers = Online::where($column, $chat_id)->with('user')->get()->pluck('user');

        $this->triggerPusher($room, 'onlineUsers', $onlineUsers);
    }

    protected function insertOnlineGroup($user, $room, $room_name)
    {
        $online = new Online();
        $online->user_id = $user;
        if ($room_name === 'friend') $online->chat_id = $room;
        if ($room_name === 'group') $online->group_id = $room;
        $online->timelogin = time();
        $online->save();
    }


}
