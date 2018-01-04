<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->firstName . ' ' . $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'status' => $faker->text(70),
        'avatar' => $faker->imageUrl(400, 400),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10)
    ];
});

$factory->define(App\Friendship::class, function (Faker $faker) {
    return [
        'requester' =>  function ()
                        {
                            return factory(\App\User::class)->create()->id;
                        },
        'user_requested' => function ()
                            {
                                return factory(\App\User::class)->create()->id;
                            },
        'status' => 0
    ];
});

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function ()
                     {
                        return factory(\App\User::class)->create()->id;
                     },
    ];
});