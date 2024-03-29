<?php

/** @var Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

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
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'job_title' => $faker->text(30),
        'linkedin_id' => $faker->unique()->text(20),
        'linkedin_token' => $faker->unique()->text(20),
        'team_name' => $faker->text(30),
        'country' => $faker->countryCode,
        'bio' => $faker->text(120),
    ];
});

$factory->state(User::class, 'verified', [
        'email_verified_at' => now(),
]);
