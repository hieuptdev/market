<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'title' => $faker->name,
        'category_id' => 1,
        'attributes' => $faker->name,
        'address_id' => User::inRandomOrder()->first()->id,
        'price' => 999999.9999,
        'desc' => $faker->sentence,
        'image' => $faker->name,
        'status' => 1,
    ];
});
