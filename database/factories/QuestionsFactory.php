<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence($faker->numberBetween(5, 10)) . "?",
        'a' => $faker->word,
        'b' => $faker->word,
        'c' => $faker->word,
        'd' => $faker->word,
        'answer' => $faker->randomElement(['a', 'b', 'c', 'd']),
        'answer_explanation' => $faker->boolean(50) ? $faker->paragraph : NULL,
    ];
});
