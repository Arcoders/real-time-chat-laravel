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

/*    public function change_statue_to_pending_and_waiting()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $sender->addFriend($recipient);
        $this->assertEquals('pending', $recipient->checkFriendship($sender));
        $this->assertEquals('waiting', $sender->checkFriendship($recipient));
    }*/

    public function test_change_status_to_pending_and_waiting()
    {

        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->addFriend($recipient->id);

        $this->assertEquals('pending', $recipient->checkFriendship($sender->id));
        $this->assertEquals('waiting', $sender->checkFriendship($recipient->id));

    }

}
