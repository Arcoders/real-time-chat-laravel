<?php

namespace App\Http\Controllers;
use App\Chat;
use App\Notifications\AcceptFriendRequest;
use App\Notifications\NewFriendRequest;
use App\Traits\TriggerPusher;
use App\User;
use Illuminate\Support\Facades\Auth;

class FriendshipsController extends Controller
{

    use TriggerPusher;

    public function check($id)
    {

        return response()->json(['status' => Auth::user()->checkFriendship($id)], 200);

    }

    public function add($id)
    {

        return response()->json(Auth::user()->add_friend($id), 200);

    }

    public function accept($id)
    {

        return response()->json(Auth::user()->accept_friends($id), 200);

    }

    public function reject($id)
    {

        return response()->json(Auth::user()->reject_friendships($id), 200);

    }

    public function friend($friend_id)
    {

        return response()->json(User::find($friend_id), 200);

    }

}
