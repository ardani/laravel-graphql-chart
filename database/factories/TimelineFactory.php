<?php

use Faker\Generator as Faker;

$factory->define(\App\Timeline::class, function (Faker $faker) {
    $date = \Carbon\Carbon::now();
    return [
        'feed_count' => rand(50, 300),
        'feed_retweet_count' => rand(20, 100),
        'date' => $date->addDays(rand(1, 100))->format('Y-m-d')
    ];
});
