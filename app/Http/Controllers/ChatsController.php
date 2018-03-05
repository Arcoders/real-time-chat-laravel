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
            array_push($allGroups, collect($group)->prepend($group->messages->last(), 'msg'));
        endforeach;

        return $allGroups;
    }

    protected function chatFriends()
    {

        $user = Auth::user();
        $allChats = array();

        $a = Friendship::whereSender($user)->accepted(1)->select('id', 'requested')->with('friend')->get();

        $b = Friendship::whereRecipient($user)->accepted(1)->select('id', 'requester')->with('user')->get();

        foreach ($a->merge($b) as $chat):

            array_push($allChats, collect($chat)->prepend($chat->messages->last(), 'msg'));

        endforeach;

        return $allChats;

    }

    public function myChats()
    {
        $user = Auth::user();

        $chats = array_merge(
            Friendship::whereSender($user)->accepted(1)->pluck('id')->toArray(),
            Friendship::whereRecipient($user)->accepted(1)->pluck('id')->toArray()
        );

        return response()->json($chats, 200);

    }

}
