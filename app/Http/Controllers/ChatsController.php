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

    protected function chatGroups()
    {
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

    protected function chatFriends()
    {

        $user = Auth::user();
        $allChats = array();

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

        $c = array_merge($a, $b);

        foreach ($c as $chat):

            $message = Message::where('chat_id', $chat['id'])->get()->last();

            $chat = collect($chat);

            array_push($allChats, $chat->push($message));

        endforeach;

        return $allChats;

    }

    public function myChats()
    {
        $user_id = Auth::user()->id;

        $chat = Chat::where('user_id', $user_id)->orWhere('friend_id', $user_id)->pluck('id');

        return response()->json($chat, 200);

    }

}
