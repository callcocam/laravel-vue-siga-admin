<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\File::class, function (Faker $faker) {
    return [
        'name'=>'/users/no_avatar.jpg'
    ];
});
