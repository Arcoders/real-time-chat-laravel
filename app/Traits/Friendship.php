<?php

namespace App\Traits;
use App\Friendship as ModelFriends;
use App\Notifications\AcceptFriendRequest;
use App\Notifications\NewFriendRequest;
use App\User;

trait Friendship
{

    use TriggerPusher;

    public function addFriend($recipientId)
    {

        $status = $this->checkFriendship($recipientId);

        if ($status == 'add') {

            if ($this->restoreFriendship($recipientId) == 'create') {

                ModelFriends::create(['requester' => $this->id, 'requested' => $recipientId]);

            }

            $this->notifyRequestSent($recipientId);

            return 'waiting';

        }

        return $status;

    }

    public function acceptFriend($senderId)
    {

        $status = $this->checkFriendship($senderId);

        if ($status == 'pending') {

            ModelFriends::betweenUsers($this, User::find($senderId))->update(['status' => 1]);

            $this->notifyAcceptedRequest($senderId);

            return 'friends';
        }

        return $status;

    }

    public function rejectFriendship($userId)
    {

        $status = $this->checkFriendship($userId);

        if ($status != 'add') {

            $relationship = ModelFriends::betweenUsers($this, User::find($userId));

            $relationship->update(['status' => 0]);

            $relationship->delete();

            $this->removeChat($userId);

            return 'add';
        }

        return $status;

    }

    public function friends($justId = null)
    {

        $recipients = ModelFriends::accepted()->whereSender($this)->get(['requested'])->toArray();

        $senders = ModelFriends::accepted()->whereRecipient($this)->get(['requester'])->toArray();

        $friendsIds = array_merge($recipients, $senders);

        if ($justId) return static::whereIn('id', $friendsIds)->pluck('id')->toArray();

        return static::whereIn('id', $friendsIds)->get();
    }

    public function friendRequestsReceived()
    {
        return static::whereIn(
            'id', ModelFriends::pending()->whereRecipient($this)->get(['requester'])->toArray()
        )->get();
    }

    public function friendRequestsSent()
    {
        return static::whereIn(
            'id', ModelFriends::pending()->whereSender($this)->get(['requested'])->toArray()
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

    protected function restoreFriendship($id) {

        $friendship = ModelFriends::withTrashed()->betweenUsers($this, User::find($id))->first();

        if ($friendship) {

            $friendship->update(['requester' => $this->id, 'requested' => $id]);

            $friendship->restore();

            return $friendship;

        }

        return 'create';
    }

    public function isFriendsWith($user)
    {
        return $this->checkFriendship($user) === 'friends';
    }

    public function chats() {

        $a = ModelFriends::whereSender($this)->accepted()->select('id', 'requested')->with('friend')->get();

        $b = ModelFriends::whereRecipient($this)->accepted()->select('id', 'requester')->with('user')->get();

        return $a->merge($b);
    }

    public function chatsIds() {

        $a = ModelFriends::whereSender($this)->accepted()->pluck('id')->toArray();

        $b = ModelFriends::whereRecipient($this)->accepted()->pluck('id')->toArray();

        return  array_merge($a, $b);
    }

    protected function notifyRequestSent($recipientId)
    {
        User::find($recipientId)->notify(new NewFriendRequest());

        $this->triggerPusher("user$recipientId", 'updateStatus', []);

        $this->triggerPusher("user$this->id", 'updateStatus', []);

        $this->triggerPusher("notification$recipientId", 'updateNotifications', []);
    }

    protected function notifyAcceptedRequest($senderId)
    {
        User::find($senderId)->notify(new AcceptFriendRequest());

        $this->triggerPusher("user$senderId", 'updateStatus', ['type' => 'chat', 'id' => $this->id]);

        $this->triggerPusher("user$this->id", 'updateStatus', ['type' => 'chat', 'id' => $senderId]);

        $this->triggerPusher("notification$senderId", 'updateNotifications', []);
    }

    protected function removeChat($userId)
    {
        $this->triggerPusher("user$userId", 'updateStatus', ['type' => 'chat']);

        $this->triggerPusher("user$this->id", 'updateStatus', ['type' => 'chat']);
    }

}