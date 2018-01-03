<?php

namespace App\Http\Controllers;

use App\OnlineGroup;
use App\Traits\TriggerPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineInGroupsController extends Controller
{
    use TriggerPusher;

    public function OnlineGroupUsers(Request $request)
    {

        $user = Auth::user();

        if (OnlineGroup::where('user_id', $user->id)->count() === 0) {

            $this->insertOnlineGroup($user->id, $request->group_id);

        } else {

            $leaveGroup = OnlineGroup::where('user_id', $user->id)->get()[0];
            OnlineGroup::where('user_id', $user->id)->delete();

            $onlineUsers = OnlineGroup::where('group_id', $leaveGroup->group_id)->with('user')->get()->pluck('user');
            $this->triggerPusher('room-' . $leaveGroup->group_id, 'onlineUsers', $onlineUsers);

            $this->insertOnlineGroup($user->id, $request->group_id);
        }

        $onlineUsers = OnlineGroup::where('group_id', $request->group_id)->with('user')->get()->pluck('user');

        $this->triggerPusher('room-' . $request->group_id, 'onlineUsers', $onlineUsers);

        return response()->json($onlineUsers, 200);

    }


    protected function insertOnlineGroup($user, $room)
    {
        $online = new OnlineGroup();
        $online->user_id = $user;
        $online->group_id = $room;
        $online->timelogin = time();
        $online->save();
    }

}
