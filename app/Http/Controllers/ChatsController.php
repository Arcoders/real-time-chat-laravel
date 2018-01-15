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

        $chats = Chat::with('user')
            ->with('friend')
            ->where('user_id', $user->id)
            ->orWhere('friend_id', $user->id)
            ->get();

        return $this->filterUsers($chats);

    }

    protected function filterUsers($chats) {

        $a = $chats->filter(function ($value) {

            return $value->user_id === Auth::id();

        })->pluck('id', 'friend')->toArray();

        // ....

        $b = $chats->filter(function ($value) {

            return $value->friend_id === Auth::id();

        })->pluck('id', 'user')->toArray();

        return $a + $b;

    }

}
