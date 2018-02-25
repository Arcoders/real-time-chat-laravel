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

        if (in_array($id, $user->friends())) return $this->status('friends');

        if (in_array($id, $user->pending_friend_requests())) return $this->status('pending');

        if (in_array($id, $user->pending_friend_requests_sent())) return $this->status('waiting');

        return $this->status('add');

    }

    public function addFriend($id)
    {
        $add = Auth::user()->add_friend($id);
        if ($add)
        {
            User::find($id)->notify(new NewFriendRequest());
            $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
            $this->triggerPusher('notification'.$id, 'updateNotifications', []);
            return response()->json($add, 200);
        }
    }

    public function acceptFriend($id)
    {

        $chat= new Chat();
        $chat->user_id = Auth::user()->id;
        $chat->friend_id = $id;

        if ($chat->save())
        {
            $accept = Auth::user()->accept_friends($id);
            if ($accept)
            {
                User::find($id)->notify(new AcceptFriendRequest());
                $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
                $this->triggerPusher('notification'.$id, 'updateNotifications', []);
                return response()->json($accept, 200);
            } else {
                $chat->delete();
            }
        } else {
            return response()->json('pending', 200);
        }

    }

    public function rejectFriendship($id)
    {
        $reject = Auth::user()->reject_friendships($id);
        if ($reject)
        {
            $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
            return response()->json($reject, 200);
        }
    }

    protected function status($type)
    {
        return response()->json([
            'status' => $type
        ], 200);
    }

    public function getFriendForChat($friend_id)
    {
        $friend = User::find($friend_id);

        if ($friend) return response()->json($friend, 200);
    }

}
