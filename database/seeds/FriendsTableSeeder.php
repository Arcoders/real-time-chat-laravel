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

    }
}
