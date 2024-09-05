<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            "full_name"         =>  "admin",
            "user_name"         =>  "admin",
            "phone"             =>  "01688158696",
            "email"             =>  "admin@admin.com",
            "password"          =>  bcrypt("admin@admin.com"),
            "is_admin"          =>  1,
            "is_active"         =>  1
        ]);
    }
}
