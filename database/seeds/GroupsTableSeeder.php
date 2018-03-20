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

        foreach (range(4, 15) as $i):

            factory(\App\Group::class)->create(['user_id' => 1])->users()->sync([1, $i]);

            factory(\App\Message::class)->create(['user_id' =>  ($i % 2) ? $i : 1, 'group_chat' => rand(4, $i)]);

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
