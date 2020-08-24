<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->delete();
        DB::table('role')->insert([
            ['id' => 1, 'name' => 'Admin',],
            ['id' => 2, 'name' => 'User'],
            ['id' => 3, 'name' => 'Editor'],
            ['id' => 4, 'name' => 'Manager'],
            ['id' => 5, 'name' => 'Content'],
        ]);
    }
}
