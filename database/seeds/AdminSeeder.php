<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin;
        $admin->name = 'Khai';
        $admin->email = 'nguyenkhai321ls@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->role_id = 1;
        $admin->save();

        $admin = new Admin;
        $admin->name = 'Hieu';
        $admin->email = 'hieu@gmail.com';
        $admin->password = bcrypt('hi3uhi3u');
        $admin->role_id = 1;
        $admin->save();
    }
}
