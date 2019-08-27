<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'givenName' => $faker->name,
        'familyName' => $faker->name,
        'password' => $password ?: $password = Hash::make('secret'),
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'bilbo', function () {
    return [
        'email' => 'bilbo@baggins.uk',
        'givenName' => 'Bilbo',
        'familyName' => 'Baggins',
        'password' => '_my_pr3c10u5_'
    ];
});
