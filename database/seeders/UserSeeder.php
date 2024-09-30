<?php

namespace Database\Seeders;

use App\Models\Items;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();

        // for ($i = 0; $i < 20000; $i++) {
        //     if (!file_exists(storage_path('users'))) {
        //         mkdir(storage_path('users'), 0755, true);
        //     }
        //     $imagePath = $faker->image(storage_path('users'), 50, 50, null, false);
        //     $filename = Str::random(10) . '.jpg';
        //     rename(storage_path('users/' . $imagePath), storage_path('users/' . $filename));
        //     User::create([
        //         "full_name" =>  $faker->name,
        //         "phone"     =>  mt_rand(100000000, 999999999),  
        //         "email"     =>  $faker->unique()->safeEmail,  
        //         "password"  =>  bcrypt('123456'),
        //         "is_admin"  =>  0,
        //         "is_active" =>  0,
        //         'image'     => 'users/' . $filename,
        //     ]);
        // }
    }
}
