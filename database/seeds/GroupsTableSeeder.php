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

        $group_arc = factory(\App\Group::class)->create([
            'name' => 'Arcoders',
            'user_id' => 1
        ]);

        $group_arc->users()->sync([1, 2]);

        $group_fut = factory(\App\Group::class)->create([
            'name' => 'Fustal Vidreras',
            'user_id' => 1
        ]);

        $group_fut->users()->sync([1, 2, 3]);

        $group_tec = factory(\App\Group::class)->create([
            'name' => 'Tecnología',
            'user_id' => 3
        ]);

        $group_tec->users()->sync([3, 1]);

    }
}
