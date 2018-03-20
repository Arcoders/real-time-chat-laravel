<?php

use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\Friendship::class)->create([
            'requester' =>  2,
            'requested' => 1,
            'status' => 0
        ]);

        factory(\App\Friendship::class)->create([
            'requester' =>  2,
            'requested' => 3,
            'status' => 0
        ]);

        factory(\App\Friendship::class)->create([
            'requester' =>  3,
            'requested' => 1,
            'status' => 0
        ]);

        foreach (range(4, 12) as $i):

            factory(\App\Friendship::class)->create(['requester' =>  1, 'requested' => $i, 'status' => 1]);

            foreach (range(1, $i) as $j):

                factory(\App\Message::class)->create(['user_id' =>  ($j % 2) ? $i : 1, 'friend_chat' => $i]);

            endforeach;

        endforeach;

    }
}
