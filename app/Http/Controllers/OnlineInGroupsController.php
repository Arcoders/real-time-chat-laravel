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

            $lastGroup = OnlineGroup::where('user_id', $user->id);
            $lastGroupInfo = $lastGroup->first();

            $lastGroup->delete();

            $this->updateOnlineUsers($lastGroupInfo->group_id);

            $this->insertOnlineGroup($user->id, $request->group_id);
        }

        $this->updateOnlineUsers($request->group_id);

    }

    protected function updateOnlineUsers($group_id)
    {
        $onlineUsers = OnlineGroup::where('group_id', $group_id)->with('user')->get()->pluck('user');

        $this->triggerPusher('room-' . $group_id, 'onlineUsers', $onlineUsers);
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
