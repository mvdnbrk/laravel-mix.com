<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Extension::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
