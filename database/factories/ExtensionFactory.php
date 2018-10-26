<?php

use Faker\Generator as Faker;

$factory->define(App\Extension::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
