<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->delete();
        //id	name	slug	created_at	updated_at
        DB::table('permission')->insert([
            ['id' => 1, 'name' => 'User Read', 'slug' => 'user-read'],
            ['id' => 2, 'name' => 'User Create', 'slug' => 'user-create'],
            ['id' => 3, 'name' => 'User Edit', 'slug' => 'user-edit'],
            ['id' => 4, 'name' => 'User Delete', 'slug' => 'user-delete'],
            //
            ['id' => 5, 'name' => 'Roles Read', 'slug' => 'roles-read'],
            ['id' => 6, 'name' => 'Roles Create', 'slug' => 'roles-create'],
            ['id' => 7, 'name' => 'Roles Edit', 'slug' => 'roles-edit'],
            ['id' => 8, 'name' => 'Roles Delete', 'slug' => 'roles-delete'],
            //
            ['id' => 9, 'name' => 'Product Read', 'slug' => 'product-read'],
            ['id' => 10, 'name' => 'Product Create', 'slug' => 'product-create'],
            ['id' => 11, 'name' => 'Product Edit', 'slug' => 'product-edit'],
            ['id' => 12, 'name' => 'Product Delete', 'slug' => 'product-delete'],
            //
            ['id' => 13, 'name' => 'Admin Read', 'slug' => 'admin-read'],
            ['id' => 14, 'name' => 'Admin Create', 'slug' => 'admin-create'],
            ['id' => 15, 'name' => 'Admin Edit', 'slug' => 'admin-edit'],
            ['id' => 16, 'name' => 'Admin Delete', 'slug' => 'admin-delete'],
            //
            ['id' => 17, 'name' => 'Review Read', 'slug' => 'review-read'],
            ['id' => 18, 'name' => 'Review Create', 'slug' => 'review-create'],
            ['id' => 19, 'name' => 'Review Edit', 'slug' => 'review-edit'],
            ['id' => 20, 'name' => 'Review Delete', 'slug' => 'review-delete'],
            //
            ['id' => 21, 'name' => 'Category Read', 'slug' => 'category-read'],
            ['id' => 22, 'name' => 'Category Create', 'slug' => 'category-create'],
            ['id' => 23, 'name' => 'Category Edit', 'slug' => 'category-edit'],
            ['id' => 24, 'name' => 'Category Delete', 'slug' => 'category-delete'],

        ]);
    }
}
