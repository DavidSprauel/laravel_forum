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

$factory->define(Forum\Models\Entities\Eloquent\User::class, function (Faker $faker) {
    static $password;
    
    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ? : $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed'      => true,
    ];
});

$factory->state(\Forum\Models\Entities\Eloquent\User::class, 'unconfirmed', function () {
    return [
        'confirmed' => false
    ];
});

$factory->state(\Forum\Models\Entities\Eloquent\User::class, 'admin', function () {
    return [
        'name' => 'JohnDoe'
    ];
});
