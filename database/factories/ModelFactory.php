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

$factory->define(App\User::class, function ($faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Problem::class, function ($faker) {
    return [
        'title'         => $faker->company,
        'description'   => join('\n\n', $faker->paragraphs($faker->numberBetween(1,5))),
        'input'         => $faker->paragraph,
        'output'        => $faker->paragraph,
        'sample_input'  => $faker->postcode,
        'sample_output' => $faker->city,
        'time_limit'    => ($faker->numberBetween(1, 3) * 1000),
        'memory_limit'  => ($faker->numberBetween(1, 5) * 128)
    ];
});