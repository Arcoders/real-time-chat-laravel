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
                    ->get()
                    ->toArray();

        return response()->json([
            'groups' => $allGroups,
            'friends' => $friends
        ], 200);
    }

}
