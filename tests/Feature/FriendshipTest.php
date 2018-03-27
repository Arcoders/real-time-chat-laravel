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

}
