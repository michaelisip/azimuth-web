<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quiz;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'description' => $faker->paragraph(5),
        'points_per_question' => $faker->numberBetween(1, 10),
        'timer' => $faker->randomElement([10, 20, 30, 40, 50, 60])
    ];
});
