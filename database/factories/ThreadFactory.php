<?php

use Faker\Generator as Faker;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;

$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->sentence();
    
    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph(),
        'slug' => str_slug($title),
        'locked' => false
    ];
});
