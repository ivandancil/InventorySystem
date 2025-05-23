<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create an admin user
         User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Use a strong password in production
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Belizardo Valdez',
            'email' => 'belizardovaldez@gmail.com',
            'password' => Hash::make('password'), // Use a strong password in production
            'role' => 'admin',
        ]);

        

    }
}
