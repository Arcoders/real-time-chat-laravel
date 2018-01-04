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
            'user_requested' => 1,
            'status' => 0
        ]);

        factory(\App\Friendship::class)->create([
            'requester' =>  2,
            'user_requested' => 3,
            'status' => 1
        ]);

        factory(\App\Friendship::class)->create([
            'requester' =>  3,
            'user_requested' => 1,
            'status' => 1
        ]);

    }
}
