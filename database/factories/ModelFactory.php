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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Profile::class, function (Faker\Generator $faker) {
    return [
        "user_id" => 1,
        "first_name" => "Austin",
        "last_name" => "Jenkins",
        "username" => "austin_jenkins",
        "biography" => "I love running around Jersey City and Hoboken.",
    ];
});

$factory->state(App\Profile::class, 'public', function ($faker) {
    return [
        "public" => 1,
    ];
});

$factory->state(App\Profile::class, 'unpublished', function ($faker) {
    return [
        "public" => 0,
    ];
});

