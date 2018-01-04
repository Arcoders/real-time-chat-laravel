<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class)->create([
            'name' => 'Ismael Haytam',
            'status' => 'Full Stack developer todo terreno',
            'email' => 'anonismaa@gmail.com',
            'avatar' =>  null,
            'password' => bcrypt('secret')
        ]);

        factory(User::class)->create([
            'name' => 'Victor crack',
            'status' => 'Soy un amante de los juegos',
            'avatar' =>  null,
            'email' => 'victor@gmail.com'
        ]);

        factory(User::class)->create([
            'name' => 'Marta Lopez',
            'status' => 'Lorem ipsum dolor set amet',
            'avatar' =>  null,
            'email' => 'marta@gmail.com'
        ]);

        factory(User::class, 12)->create();

    }
}
