<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Friendship;
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
            array_push($allGroups, $this->lastMessage($group));
        endforeach;

        return $allGroups;
    }

    protected function chatFriends()
    {
        $allChats = array();

        foreach (Auth::user()->chats() as $chat):

            array_push($allChats, $this->lastMessage($chat));

        endforeach;

        return $allChats;
    }

    public function myChats()
    {
        return response()->json(Auth::user()->chatsIds(), 200);
    }

    protected function lastMessage($chat) {

        return collect($chat)->prepend($chat->messages->last(), 'msg');

    }

}
