<?php

namespace App\Traits;
use App\Friendship as ModelFriends;

trait Friendship
{

    public function add_friend($id)
    {
        if ($this->id === $id) return 0;

        if (in_array($id, $this->friends())) return 'Already friends';

        if (in_array($id, $this->pending_friend_requests_sent())) return 'Already sent';

        if (in_array($id, $this->pending_friend_requests()))
        {
            return $this->accept_friends($id);
        }

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

    public function friends($ids = null)
    {
        $requester_option = array();
        $requested_option = array();

        $requester = ModelFriends::where('status', 1)
                    ->where('requester', $this->id)
                    ->with('requester')
                    ->get()
                    ->toArray();

        foreach ($requester as $friend):
              array_push($requester_option, array_get($friend, $ids ? 'requester' : 'requester.id'));
        endforeach;

        $requested = ModelFriends::where('status', 1)
                    ->where('requested', $this->id)
                    ->with('requested')
                    ->get()
                    ->toArray();

        foreach ($requested as $friend):
            array_push($requested_option, array_get($friend, $ids ? 'requested' : 'requested.id'));
        endforeach;

        return array_merge($requester_option, $requested_option);
    }

    public function pending_friend_requests()
    {
        return $this->getPending('requested');
    }

    public function pending_friend_requests_sent()
    {
        return $this->getPending('requester');
    }

    protected function getPending($type)
    {
        $pending = array();

        $Friendships = ModelFriends::where('status', 0)->where($type, $this->id)->with($type)->get()->toArray();

        foreach ($Friendships as $friend):
            array_push($pending, array_get($friend, "$type.id"));
        endforeach;

        return $pending;
    }

}