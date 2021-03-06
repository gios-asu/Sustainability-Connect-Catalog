<?php

use Faker\Generator;
use Webpatser\Uuid\Uuid;
use SCCatalog\Models\Auth\User;

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

$factory->define(User::class, function (Generator $faker) {
    return [
        'uuid' => Uuid::generate(4)->string,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'password' => 'secret',
        'password_changed_at' => null,
        'remember_token' => str_random(10),
        'confirmation_code' => md5(uniqid(mt_rand(), true)),
        'active' => 1,
        'confirmed' => 1,
        'user_type_id' => 1,
    ];
});

$factory->state(User::class, 'student', function () {
    return [
        'user_type_id' => 1,
    ];
});

$factory->state(User::class, 'alumni', function () {
    return [
        'user_type_id' => 2,
    ];
});

$factory->state(User::class, 'faculty', function () {
    return [
        'user_type_id' => 3,
    ];
});

$factory->state(User::class, 'staff', function () {
    return [
        'user_type_id' => 4,
    ];
});

$factory->state(User::class, 'professional', function () {
    return [
        'user_type_id' => 5,
    ];
});

$factory->state(User::class, 'active', function () {
    return [
        'active' => 1,
    ];
});

$factory->state(User::class, 'inactive', function () {
    return [
        'active' => 0,
    ];
});

$factory->state(User::class, 'confirmed', function () {
    return [
        'confirmed' => 1,
    ];
});

$factory->state(User::class, 'unconfirmed', function () {
    return [
        'confirmed' => 0,
    ];
});

$factory->state(User::class, 'softDeleted', function () {
    return [
        'deleted_at' => \Illuminate\Support\Carbon::now(),
    ];
});
