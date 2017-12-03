<?php

use Faker\Generator as Faker;

$factory->define(\Forum\Models\Entities\Eloquent\Notification::class, function (Faker $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => \Forum\Notifications\ThreadWasUpdated::class,
        'notifiable_id' => function() {
            return auth()->id() ? : factory(User::class)->create()->id;
        },
        'notifiable_type' => \Forum\Models\Entities\Eloquent\User::class,
        'data'=> ['foo' => 'bar']
    ];
});
