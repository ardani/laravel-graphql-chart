<?php

use Faker\Generator as Faker;

$factory->define(\App\Feed::class, function (Faker $faker) {
    $user = App\User::inRandomOrder()->first();
    $parent = array_random([0, rand(1, 10)]);
    return [
        'message' => $parent ? null : $faker->sentence($nbWords = 6, $variableNbWords = true),
        'type' => array_random([1, 2]),
        'user_id' => $user->id,
        'parent_id' => $parent
    ];
});
