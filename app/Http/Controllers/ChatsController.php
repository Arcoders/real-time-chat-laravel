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
        $allGroups = array();

        foreach (Auth::user()->groups as $group):

            array_push($allGroups, collect($group)->push(Message::where('group_chat', $group->id)->get()->last()));

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

        foreach (array_merge($a, $b) as $chat):

            array_push($allChats, collect($chat)->push(Message::where('friend_chat', $chat['id'])->get()->last()));

        endforeach;

        return $allChats;

    }

    public function myChats()
    {
        $user_id = Auth::user()->id;

        $chat = Chat::where('user_id', $user_id)->orWhere('friend_id', $user_id)->pluck('id');

        if ($chat) return response()->json($chat, 200);

    }

}
