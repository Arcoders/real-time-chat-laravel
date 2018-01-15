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

        $groups = $user->groups;

        foreach ($groups as $group):

            $message = Message::where('group_id', $group->id)->get()->last();

            $group = collect($group);

            array_push($allGroups, $group->push($message));

        endforeach;


        $friends = Chat::with('user')
                    ->with('friend')
                    ->where('user_id', $user->id)
                    ->orWhere('friend_id', $user->id)
                    ->get();

        $o1 = $friends->filter(function ($value) {
            return $value->user_id === Auth::id();
        });

        $o2 = $friends->filter(function ($value) {
            return $value->friend_id === Auth::id();
        });

        $o1 = $o1->pluck('id', 'friend')->toArray();
        $o2 = $o2->pluck('id', 'user')->toArray();

        $o3 = array_merge($o1,$o2);

        return response()->json([
            'groups' => $allGroups,
            'friends' => $o3
        ], 200);
    }

}
