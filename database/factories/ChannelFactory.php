<?php

use Faker\Generator as Faker;
use Forum\Models\Entities\Eloquent\Channel;

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->word;
    
    return [
        'name' => $name,
        'slug' => $name
    ];
});
