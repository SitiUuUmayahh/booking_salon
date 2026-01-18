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
        // Buat Admin User (atau update jika sudah ada)
        User::updateOrCreate(
            ['email' => 'admin@dsisisalon.com'], // kondisi pencarian
            [
                'name' => 'Admin Dsisi Salon',
                'password' => Hash::make('admin123'),
                'phone' => '081234567890',
                'role' => 'admin'
            ]
        );

        // Buat User Biasa untuk Testing (atau update jika sudah ada)
        User::updateOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
                'phone' => '081234567891',
                'role' => 'user'
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'phone' => '081234567892',
                'role' => 'user'
            ]
        );

        echo "✅ Admin dan test users berhasil dibuat/diupdate!\n";
    }
}
