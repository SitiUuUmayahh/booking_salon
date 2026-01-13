<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Admin User
        User::create([
            'name' => 'Admin Dsisi Salon',
            'email' => 'admin@dsisisalon.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'role' => 'admin'
        ]);

        // Buat User Biasa untuk Testing
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567891',
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567892',
            'role' => 'user'
        ]);

        echo "✅ Admin dan test users berhasil dibuat!\n";
    }
}
