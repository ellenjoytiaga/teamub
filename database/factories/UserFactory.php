<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
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

$factory->define(users::class, function (Faker $faker) {
    return [
        'name' =>'Admin',
        'email' =>'Admin@email.com',
        'admin' => '0',
        'email_verified_at' => now(),
        'password' => 'Admin', // password
        'remember_token' => Str::random(10),
    ];
});
