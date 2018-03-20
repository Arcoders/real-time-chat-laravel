<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (range(1, 15) as $i):

            factory(\App\Group::class)->create(['user_id' => 1])->users()->sync([1, $i]);

            foreach (range(1, $i) as $j):

                factory(\App\Message::class)->create(['user_id' =>  ($j % 2) ? $j : 1, 'group_chat' => rand(1, $j)]);

            endforeach;

        endforeach;


        factory(\App\Group::class)->create([
            'name' => 'Arcoders',
            'avatar' => NULL,
            'user_id' => 1,
            'deleted_at' => NULL
        ])->users()->sync([1, 2]);


        factory(\App\Group::class)->create([
            'name' => 'Fustal Vidreras',
            'avatar' => NULL,
            'user_id' => 1,
            'deleted_at' => NULL
        ])->users()->sync([1, 2, 3]);


        factory(\App\Group::class)->create([
            'name' => 'Tecnología',
            'avatar' => NULL,
            'user_id' => 3,
            'deleted_at' => NULL
        ])->users()->sync([3, 1]);


    }
}
