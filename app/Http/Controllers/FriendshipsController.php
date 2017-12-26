<?php

namespace App\Http\Controllers;

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
        $acc = Auth::user()->accept_friends($id);
        $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
        return $acc;
    }

    public function reject_friendship($id)
    {
        $reject = Auth::user()->reject_friendships($id);
        $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
        return $reject;
    }


}
