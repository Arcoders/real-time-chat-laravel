<?php

namespace App\Http\Controllers;
use App\Chat;
use App\Traits\TriggerPusher;
use Illuminate\Support\Facades\Auth;

class FriendshipsController extends Controller
{

    use TriggerPusher;

    public function check($id)
    {

        if (in_array($id, Auth::user()->friends()))
        {
            return ['status' => 'friends'];
        }

        if (in_array($id, Auth::user()->pending_friend_requests()))
        {
            return ['status' => 'pending'];
        }

        if (in_array($id, Auth::user()->pending_friend_requests_sent()))
        {
            return ['status' => 'waiting'];
        }
        return ['status' => 0];
    }

    public function add_friend($id)
    {
        $add = Auth::user()->add_friend($id);
        $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
        return $add;
    }

    public function accept_friend($id)
    {

        $chat= new Chat();
        $chat->user_id = Auth::user()->id;
        $chat->friend_id = $id;

        if ($chat->save())
        {
            $accept = Auth::user()->accept_friends($id);
            if ($accept)
            {
                $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
                return $accept;
            }
        } else {
            return 0;
        }

    }

    public function reject_friendship($id)
    {
        $reject = Auth::user()->reject_friendships($id);
        $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
        return $reject;
    }

}
