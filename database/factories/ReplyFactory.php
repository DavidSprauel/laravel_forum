<?php

use Faker\Generator as Faker;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\User;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'thread_id' => function() {
            return factory(Thread::class)->create()->id;
        },
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'body' => $faker->paragraph()
    ];
});
