<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'id' => Category::inRandomOrder()->first()->id,
        'name' => $faker->name,
        'parent_id' => Category::inRandomOrder()->first()->id,
        'attribute' => $faker->name,

    ];
});
