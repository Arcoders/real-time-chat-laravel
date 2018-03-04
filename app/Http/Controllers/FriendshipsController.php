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

        $user = Auth::user();

        $relation = $user->checkFriendship($id);

        return $this->status($relation);

    }

    public function addFriend($id)
    {
        $add = Auth::user()->add_friend($id);

        if ($add) return response()->json($add, 200);
    }

    public function acceptFriend($id)
    {

        $accept = Auth::user()->accept_friends($id);

        if ($accept == 'friends') {

            $chat= new Chat();
            $chat->user_id = Auth::user()->id;
            $chat->friend_id = $id;
            $chat->save();

        }

        return response()->json($accept, 200);

    }

    public function rejectFriendship($id)
    {
        $reject = Auth::user()->reject_friendships($id);

        if ($reject) return response()->json($reject, 200);

    }

    protected function status($type)
    {
        return response()->json(['status' => $type], 200);
    }

    public function getFriendForChat($friend_id)
    {
        $friend = User::find($friend_id);

        if ($friend) return response()->json($friend, 200);
    }

}
