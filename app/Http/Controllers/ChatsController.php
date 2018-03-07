<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chatsList()
    {

        $chats = [
            'groups' => $this->getLastMessage(Auth::user()->groups),
            'friends' => $this->getLastMessage(Auth::user()->chats())
        ];

        return response()->json($chats, 200);
    }

    public function myChats()
    {
        return response()->json(Auth::user()->chatsIds(), 200);
    }

    protected function getLastMessage($chats) {

        $data = array();

        foreach ($chats as $chat):

            array_push($data, collect($chat)->prepend($chat->messages->last(), 'msg'));

        endforeach;

        return $data;

    }

}
