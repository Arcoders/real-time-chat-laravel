<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chatsList()
    {
        $allGroups = array();

        $groups = Auth::user()->groups;

        foreach ($groups as $group):

            $message = Message::where('group_id', $group->id)->get()->last();

            $group = collect($group);

            array_push($allGroups, $group->push($message));

        endforeach;

        return response()->json([
            'groups' => $allGroups,
            'friends' => Auth::user()->friends(true)
        ], 200);
    }

}
