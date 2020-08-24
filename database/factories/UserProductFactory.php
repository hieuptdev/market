<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Product;
use App\Models\UserProduct;
use Faker\Generator as Faker;

$factory->define(UserProduct::class, function (Faker $faker) {
 	static $status = ['sold', 'bought'];
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'product_id' => Product::inRandomOrder()->first()->id,
        'status' => $status[rand(0,1)],
    ];
});
