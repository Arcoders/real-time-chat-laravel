<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chatsList()
    {
        $user = Auth::user();
        $allGroups = array();
        $allFriends = array();

        $groups = $user->groups;

        foreach ($groups as $group):

            $message = Message::where('group_id', $group->id)->get()->last();

            $group = collect($group);

            array_push($allGroups, $group->push($message));

        endforeach;

        $friend_op1 = Chat::with('friend')->where('user_id', $user->id)->get()->pluck('id', 'friend');

        $friend_op2 = Chat::with('user')->where('friend_id', $user->id)->get()->pluck('id', 'user');

        $friends = $friend_op1->push($friend_op2);

        return response()->json([
            'groups' => $allGroups,
            'friends' => $friends
        ], 200);
    }

}
