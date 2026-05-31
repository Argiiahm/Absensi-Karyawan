<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed default office
        \App\Models\Office::create([
            'name' => 'Kantor Pusat',
            'latitude' => -6.20880000,
            'longitude' => 106.84560000,
            'radius' => 100, // 100 meters radius for geofencing.
        ]);

        // Seed test admin user
        \App\Models\User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@absenkita.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
            'is_face_enrolled' => false,
        ]);
    }
}
