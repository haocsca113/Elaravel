<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::truncate();

        $adminRoles = Roles::where('name', 'admin')->first();
        $authorRoles = Roles::where('name', 'author')->first();
        $userRoles = Roles::where('name', 'user')->first();

        $admin = Admin::create([
            'admin_email' => 'poghao@gmail.com',
            'admin_password' => md5('123456789'),
            'admin_name' => 'Poghao',
            'admin_phone' => '0988820943',
        ]);

        $author = Admin::create([
            'admin_email' => 'ibradong@gmail.com',
            'admin_password' => md5('123456789'),
            'admin_name' => 'Dong',
            'admin_phone' => '2988820943',
        ]);

        $user = Admin::create([
            'admin_email' => 'lukebuu@gmail.com',
            'admin_password' => md5('123456789'),
            'admin_name' => 'Buu',
            'admin_phone' => '3988820943',
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);
    }
}
