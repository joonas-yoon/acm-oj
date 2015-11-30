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
        'name'           => $faker->userName,
        'email'          => $faker->email,
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Problem::class, function ($faker) {
    return [
        'title'         => $faker->company,
        'description'   => join("\n\n", $faker->paragraphs($faker->numberBetween(1,5))),
        'input'         => $faker->paragraph,
        'output'        => $faker->paragraph,
        'sample_input'  => $faker->postcode,
        'sample_output' => join("\n", $faker->words($faker->numberBetween(1,10))),
        'time_limit'    => $faker->numberBetween(1, 5),
        'memory_limit'  => ($faker->numberBetween(1, 5) * 128),
        'is_special'    => $faker->boolean(15),
        'status'        => $faker->boolean(85)
    ];
});


$factory->define(App\Solution::class, function ($faker) {
    return [
        'lang_id'    => App\Language::all()->random()->id,
        'problem_id' => App\Problem::all()->random()->id,
        'user_id'    => App\User::all()->random()->id,
        'result_id'  => App\Result::all()->random()->id,
        'time'       => $faker->numberBetween(1, 249) * 4,
        'memory'     => $faker->numberBetween(0, 1024) * 4,
        'size'       => $faker->numberBetween(20, 1200),
        'is_hidden'  => $faker->boolean(20),
        'is_published' => $faker->boolean(95)
    ];
});
