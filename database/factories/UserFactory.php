<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Country;
use App\State;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'name'        => $faker->firstName.' '.$faker->lastName,
        'username'          => $faker->userName,
        'email'             => $faker->safeEmail,
        'email_verified_at' => $faker->dateTime(),
        'password'          => bcrypt($faker->password),
        'remember_token'    => Str::random(10),
    ];
});
