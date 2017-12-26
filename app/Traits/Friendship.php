<?php

namespace App\Traits;
use App\User;
use App\Friendship as ModelFriends;

trait Friendship
{

    public function all_users()
    {
        return User::all();
    }

    /**
     * @param $user_requested_id
     * @return int|string
     */
    public function add_friend($user_requested_id)
    {
        if ($this->id === $user_requested_id) return 0;
        if ($this->is_friends_with($user_requested_id) === 1) return 'Already friends';
        if ($this->has_pending_friend_request_sent_to($user_requested_id) === 1) return 'Already sent';

        if ($this->has_pending_friend_request_from($user_requested_id) === 1)
        {
            return $this->accept_friends($user_requested_id);
        }

        $Friendship = ModelFriends::create([
            'requester' => $this->id,
            'user_requested' => $user_requested_id
        ]);

        if ($Friendship)
        {
            return 1;
        }

        return 0;
    }

    public function accept_friends($requester)
    {
        if ($this->has_pending_friend_request_from($requester) === 0) return 0;
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
        if ($this->has_pending_friend_request_from($requester) === 0) return 0;

        $Friendship = ModelFriends::where('requester', $requester)
            ->where('user_requested', $this->id)
            ->first();

        if ($Friendship)
        {
            if ($Friendship->delete()) return 3;
        }

        return 0;
    }


    public function friends()
    {
        $requester_option = array();
        $requested_option = array();

        $requester = ModelFriends::where('status', 1)
                    ->where('requester', $this->id)
                    ->with('requester')
                    ->get()
                    ->toArray();

        foreach ($requester as $friend):
              array_push($requester_option, array_get($friend, 'requester.id'));
        endforeach;

        $requested = ModelFriends::where('status', 1)
                    ->where('user_requested', $this->id)
                    ->with('requested')
                    ->get()
                    ->toArray();

        foreach ($requested as $friend):
            array_push($requested_option, array_get($friend, 'requested.id'));
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

    public function is_friends_with($user_id)
    {
        if (in_array($user_id, $this->friends()))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function pending_friend_requests_sent()
    {
        $users = array();
        $Friendships = ModelFriends::where('status', 0)
            ->where('requester', $this->id)
            ->get();
        foreach ($Friendships as $friendship):
            array_push($users, User::find($friendship->user_requested));
        endforeach;
        return $users;
    }

    public function pending_friend_requests_sent_ids()
    {
        return collect($this->pending_friend_requests_sent())->pluck('id')->toArray();
    }

    public function has_pending_friend_request_from($user_id)
    {
        if (in_array($user_id, $this->pending_friend_requests()))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function has_pending_friend_request_sent_to($user_id)
    {
        if (in_array($user_id, $this->pending_friend_requests_sent_ids()))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }


}