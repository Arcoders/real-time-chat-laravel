<?php

namespace App\Traits;
use App\Friendship as ModelFriends;
use App\Notifications\AcceptFriendRequest;
use App\Notifications\NewFriendRequest;
use App\User;

trait Friendship
{

    use TriggerPusher;

    public function add_friend($recipientId)
    {

        $status = $this->checkFriendship($recipientId);

        if ($status == 'add') {

            ModelFriends::create(['requester' => $this->id, 'requested' => $recipientId]);

            User::find($recipientId)->notify(new NewFriendRequest());

            $this->triggerPusher('user'.$recipientId, 'updateStatus', ['update' => true]);

            $this->triggerPusher('notification'.$recipientId, 'updateNotifications', []);

            return 'waiting';
        }

        return $status;

    }

    public function accept_friends($senderId)
    {

        $status = $this->checkFriendship($senderId);

        if ($status == 'pending') {

            ModelFriends::betweenUsers($this, User::find($senderId))->update(['status' => 1]);

            User::find($senderId)->notify(new AcceptFriendRequest());

            $this->triggerPusher('user'.$senderId, 'updateStatus', ['update' => true]);

            $this->triggerPusher('notification'.$senderId, 'updateNotifications', []);

            return 'friends';
        }

        return $status;

    }

    public function reject_friendships($userId)
    {

        $status = $this->checkFriendship($userId);

        if ($status != 'add') {

            ModelFriends::betweenUsers($this, User::find($userId))->delete();

            $this->triggerPusher('user'.$userId, 'updateStatus', ['update' => true]);

            return 'add';
        }

        return $status;

    }

    public function friends($justId = null)
    {

        $recipients = ModelFriends::whereSender($this)->accepted(1)->get(['requested'])->toArray();

        $senders = ModelFriends::whereRecipient($this)->accepted(1)->get(['requester'])->toArray();

        $friendsIds = array_merge($recipients, $senders);

        if ($justId) return static::whereIn('id', $friendsIds)->pluck('id')->toArray();

        return static::whereIn('id', $friendsIds)->get();
    }

    public function friendRequestsReceived()
    {
        return static::whereIn(
            'id', ModelFriends::whereRecipient($this)->accepted(0)->get(['requester'])->toArray()
        )->get();
    }

    public function friendRequestsSent()
    {
        return static::whereIn(
            'id', ModelFriends::whereSender($this)->accepted(0)->get(['requested'])->toArray()
        )->get();
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