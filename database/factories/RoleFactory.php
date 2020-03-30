<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\App\Suports\Shinobi\Models\Role::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'id' => \Ramsey\Uuid\Uuid::uuid4(),
    ];
});
