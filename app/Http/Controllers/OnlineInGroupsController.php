<?php

namespace App\Http\Controllers;

use App\OnlineGroup;
use App\Traits\TriggerPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineInGroupsController extends Controller
{
    use TriggerPusher;

    public function onlineGroupUsers(Request $request)
    {

        $user = Auth::user();

        if (OnlineGroup::where('user_id', $user->id)->count() !== 0) {

            $lastGroup = OnlineGroup::where('user_id', $user->id);
            $lastGroupInfo = $lastGroup->first();
            $lastGroup->delete();

            $this->updateOnlineUsers($lastGroupInfo->chat_id, $request->room_name);
        }

        $this->insertOnlineGroup($user->id, $request->chat_id, $request->room_name);

        $this->updateOnlineUsers($request->chat_id, $request->room_name);

    }

    public function disconnectUser(Request $request)
    {
        OnlineGroup::where('user_id', Auth::user()->id)->delete();
        $this->updateOnlineUsers($request->chat_id, $request->room_name);
    }

    protected function updateOnlineUsers($chat_id, $room_name)
    {
        $column = ($room_name === 'friend') ? 'chat_id' : 'group_id';

        $room = ($room_name === 'friend') ? "onlineChat-$chat_id" : "onlineGroup-$chat_id";

        $onlineUsers = OnlineGroup::where($column, $chat_id)->with('user')->get()->pluck('user');

        $this->triggerPusher($room, 'onlineUsers', $onlineUsers);
    }

    protected function insertOnlineGroup($user, $room, $room_name)
    {
        $online = new OnlineGroup();
        $online->user_id = $user;
        if ($room_name === 'friend') $online->chat_id = $room;
        if ($room_name === 'group') $online->group_id = $room;
        $online->timelogin = time();
        $online->save();
    }


}
