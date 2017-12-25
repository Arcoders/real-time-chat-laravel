<?php

namespace App\Http\Controllers;

use App\Traits\TriggerPusher;

class FriendshipsController extends Controller
{

    use TriggerPusher;

    public function check($id)
    {
        if (Auth::user()->is_friends_with($id) === 1)
        {
            return ['status' => 'friends'];
        }
        if (Auth::user()->has_pending_friend_request_from($id))
        {
            return ['status' => 'pending'];
        }
        if (Auth::user()->has_pending_friend_request_sent_to($id))
        {
            return ['status' => 'waiting'];
        }
        return ['status' => 0];
    }

    public function add_friend($id)
    {
        $add = Auth::user()->add_friend($id);
        $this->trigger_pusher('user'.$id, 'updateStatus', ['update' => true]);
        return $add;
    }

    public function accept_friend($id)
    {
        $acc = Auth::user()->accept_friends($id);
        $this->trigger_pusher('user'.$id, 'updateStatus', ['update' => true]);
        return $acc;
    }

}
