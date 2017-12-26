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
            'user_requested' => $id
        ]);

        if ($Friendship)
        {
            return 1;
        }

        return 0;
    }

    public function accept_friends($requester)
    {
        if (!in_array($requester, $this->pending_friend_requests())) return 0;

        $Friendship = ModelFriends::where('requester', $requester)
                                ->where('user_requested', $this->id)
                                ->first();

        if ($Friendship)
        {
            $Friendship->update([
                'status' => 1
            ]);
            return 1;
        }

        return 0;
    }

    public function reject_friendships($requester)
    {
        if (!in_array($requester, $this->pending_friend_requests())) return 0;

        $Friendship = ModelFriends::where('requester', $requester)
            ->where('user_requested', $this->id)
            ->first();

        if ($Friendship)
        {
            if ($Friendship->delete()) return 3;
        }

        return 0;
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
                    ->where('user_requested', $this->id)
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
        $pending = array();

        $Friendships = ModelFriends::where('status', 0)
            ->where('user_requested', $this->id)
            ->with('requested')
            ->get()
            ->toArray();

        foreach ($Friendships as $friend):
            array_push($pending, array_get($friend, 'requested.id'));
        endforeach;

        return $pending;
    }

    public function pending_friend_requests_sent()
    {
        $pending = array();

        $Friendships = ModelFriends::where('status', 0)
                    ->where('requester', $this->id)
                    ->with('requester')
                    ->get()
                    ->toArray();

        foreach ($Friendships as $friend):
            array_push($pending, array_get($friend, 'requester.id'));
        endforeach;

        return $pending;

    }

}