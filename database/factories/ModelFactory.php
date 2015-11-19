<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Problem::class, function (Fake\Generator $faker) {
    return [
        'title'         => $faker->sentence,
        'description'   => $faker->paragraph,
        'input'         => $faker->paragraph,
        'output'        => $faker->paragraph,
        'sample_input'  => $faker->paragraph,
        'sample_output' => $faker->paragraph,
        'time_limit'    => ($faker->numberBetween(1, 3) * 1000),
        'memory_limit'  => ($faker->numberBetween(1, 5) * 128)
    ];
});