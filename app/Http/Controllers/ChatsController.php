<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chatsList()
    {
        return response()->json([
            'groups' => $this->chatGroups(),
            'friends' => $this->chatFriends()
        ], 200);
    }

    protected function chatGroups() {
        $user = Auth::user();
        $allGroups = array();

        $groups = $user->groups;

        foreach ($groups as $group):

            $message = Message::where('group_id', $group->id)->get()->last();

            $group = collect($group);

            array_push($allGroups, $group->push($message));

        endforeach;

        return $allGroups;
    }

    protected function chatFriends() {

        $user = Auth::user();

        $a = Chat::where('friend_id', $user->id)
            ->select('id', 'user_id')
            ->with('user')
            ->get()
            ->toArray();

        $b = Chat::where('user_id', $user->id)
            ->select('id', 'friend_id')
            ->with('friend')
            ->get()
            ->toArray();

        return array_merge($a, $b);

    }

}
