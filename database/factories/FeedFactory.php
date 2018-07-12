<?php

use Faker\Generator as Faker;

$factory->define(\App\Feed::class, function (Faker $faker, $options) {
    $user = App\User::inRandomOrder()->first();
    $feed = App\Feed::inRandomOrder()->where('parent_id', 0)->first();
    $retweet = array_key_exists('parent_id', $options);
    return [
        'message' => $retweet ? null : $faker->sentence($nbWords = 6, $variableNbWords = true),
        'type' => $retweet ? 1 : array_random([1, 2]),
        'user_id' => $user->id,
        'parent_id' => $retweet ? $feed->id : 0
    ];
});
