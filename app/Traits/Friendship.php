<?php

namespace App\Traits;
use App\Friendship as ModelFriends;
use App\User;

trait Friendship
{

    public function add_friend($recipientId)
    {

        $status = $this->checkFriendship($recipientId);

        if ($status == 'add') {

            ModelFriends::create([
                    'requester' => $this->id,
                    'requested' => $recipientId]
            );

            return 'waiting';
        }

        return $status;

    }

    public function accept_friends($sender)
    {

        $status = $this->checkFriendship($sender);

        if ($status == 'pending') {

            ModelFriends::betweenUsers($this, User::find($sender))->update(['status' => 1]);

            return 'friends';
        }

        return $status;

    }

    public function reject_friendships($user)
    {

        $status = $this->checkFriendship($user);

        if ($status != 'add') {

            ModelFriends::betweenUsers($this, User::find($user))->delete();

            return 'add';
        }

        return $status;

    }

    public function friends($justId = null)
    {
        $friendsIds = array_merge(
            ModelFriends::whereSender($this)->accepted(1)->get(['requested'])->toArray(),
            ModelFriends::whereSender($this)->accepted(1)->get(['requester'])->toArray()
        );

        if ($justId) return static::whereIn('id', $friendsIds)->pluck('id')->toArray();

        return static::whereIn('id', $friendsIds)->get();
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

    public function checkFriendship($id)
    {
        if ($this->id == $id) return 'same_user';

        $friendship = ModelFriends::betweenUsers($this, User::find($id))->first();

        if (!$friendship) return 'add';

        if ($friendship->status == 1) return 'friends';

        if ($friendship->requester == $this->id) return 'waiting';

        if ($friendship->requested == $this->id)  return 'pending';
    }

}