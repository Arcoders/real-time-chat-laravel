<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chats()
    {

        $chats = [
            'groups' => $this->getLastMessage(Auth::user()->groups),
            'friends' => $this->getLastMessage(Auth::user()->chats()),
            'chatIds' => Auth::user()->chatsIds()
        ];

        return response()->json($chats, 200);
    }

    protected function getLastMessage($chats) {

        $data = array();

        foreach ($chats as $chat):

            array_push($data, collect($chat)->prepend($chat->messages->last(), 'msg'));

        endforeach;

        return $data;

    }

}
