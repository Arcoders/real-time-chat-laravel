<?php

namespace App\Traits;
use App\Friendship as ModelFriends;

trait Friendship
{

    public function add_friend($id)
    {
        if ($this->id === $id) return false;

        if (in_array($id, $this->friends())) return 'friends';

        if (in_array($id, $this->pending_friend_requests_sent())) return 'waiting';

        if (in_array($id, $this->pending_friend_requests())) return $this->accept_friends($id);

        $Friendship = ModelFriends::create([
            'requester' => $this->id,
            'requested' => $id
        ]);

        return ($Friendship) ? 'waiting' : 'add';
    }

    public function accept_friends($requester)
    {
        if (!in_array($requester, $this->pending_friend_requests())) return 'pending';

        $Friendship = ModelFriends::where('requester', $requester)->where('requested', $this->id)->update([ 'status' => 1 ]);

        return ($Friendship) ? 'friends' : 'pending';
    }

    public function reject_friendships($requester)
    {
        if (!in_array($requester, $this->pending_friend_requests())) return 0;

        $Friendship = ModelFriends::where('requester', $requester)->where('requested', $this->id)->delete();

        return ($Friendship) ? 'deleted' : 'pending';
    }

    public function friends($user = null)
    {
        return array_merge(
            $this->filter(1, 'requester', $user ? 'requester' : 'requester.id'),
            $this->filter(1, 'requested', $user ? 'requested' : 'requested.id')
        );
    }

    public function pending_friend_requests()
    {
        return $this->filter(0, 'requested', 'requested.id');
    }

    public function pending_friend_requests_sent()
    {
        return $this->filter(0, 'requester', 'requester.id');
    }

    protected function filter($status, $type, $data)
    {
        $result = array();

        $Friendships = ModelFriends::accepted($status)->where($type, $this->id)->with($type)->get()->toArray();

        foreach ($Friendships as $friend):
            array_push($result, array_get($friend, $data));
        endforeach;

        return $result;
    }

    public function friendRequestsReceived()
    {
        $senders = ModelFriends::whereRecipient($this)->accepted(0)->get(['requester'])->toArray();

        return static::whereIn('id', $senders)->get();
    }

    public function friendRequestsSent()
    {
        $recipients = ModelFriends::whereSender($this)->accepted(0)->get(['requested'])->toArray();

        return static::whereIn('id', $recipients)->get();
    }

}