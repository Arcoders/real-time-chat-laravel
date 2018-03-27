<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class FriendshipTest extends TestCase
{

    public function test_user_can_add_a_friend()
    {

        $sender = factory(User::class)->create();
        $recipientOne = factory(User::class)->create();
        $recipientTwo = factory(User::class)->create();

        $sender->addFriend($recipientOne->id);
        $sender->addFriend($recipientTwo->id);

        $this->assertCount(2, $sender->friendRequestsSent());
        $this->assertCount(1, $recipientOne->friendRequestsReceived());
        $this->assertCount(1, $recipientTwo->friendRequestsReceived());

        $this->assertNotTrue($sender->isFriendsWith($recipientOne->id));
        $this->assertNotTrue($recipientTwo->isFriendsWith($sender->id));

    }

    public function test_user_can_not_send_a_request_to_himself()
    {

        $user = factory(User::class)->create();

        $user->addFriend($user->id);

        $this->assertCount(0, $user->friendRequestsReceived());
        $this->assertCount(0, $user->friendRequestsSent());

        $this->assertEquals('same_user', $user->checkFriendship($user->id));

    }

    public function test_change_status_to_pending_and_waiting()
    {

        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->addFriend($recipient->id);

        $this->assertEquals('pending', $recipient->checkFriendship($sender->id));
        $this->assertEquals('waiting', $sender->checkFriendship($recipient->id));

    }

    public function test_it_returns_accepted_friendships()
    {

        $sender = factory(User::class)->create();
        $recipients = factory(User::class, 3)->create();

        foreach ($recipients as $recipient) {

            $sender->addFriend($recipient->id);
            $recipient->acceptFriend($sender->id);

        }

        $this->assertCount(3, $sender->friends());

    }

    public function test_user_can_reject_the_request_and_delete_friend()
    {

        $sender = factory(User::class)->create();
        $recipients = factory(User::class, 2)->create();

        foreach ($recipients as $recipient) {

            $sender->addFriend($recipient->id);

        }

        $recipients[0]->rejectFriendship($sender->id);

        $this->assertEquals('add', $sender->checkFriendship($recipients[0]->id));

        $recipients[1]->acceptFriend($sender->id);

        $this->assertEquals('friends', $sender->checkFriendship($recipients[1]->id));

        $this->assertCount(1, $sender->friends());

        $recipients[1]->rejectFriendship($sender->id);

        $this->assertEquals('add', $sender->checkFriendship($recipients[1]->id));

        $this->assertCount(0, $sender->friends());

    }



}
