<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceMaxBookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini mengatur maksimal booking untuk setiap layanan:
     * - Potong rambut: 30 menit = 6 orang
     * - Creambath: 45 menit = 6 orang
     * - Smoothing: 3 jam = 3 orang
     * - Hair coloring: 2 jam = 3 orang
     * - Manicure: 30 menit = 3 orang
     * - Pedicure: 45 menit = 3 orang
     * - Facial treatment: 1 jam = 5 orang
     * - Hair spa: 1.5 jam = 3 orang
     */
    public function run(): void
    {
        $servicesData = [
            'Potong Rambut' => ['max_bookings' => 6, 'duration' => 30],
            'Creambath' => ['max_bookings' => 6, 'duration' => 45],
            'Smoothing' => ['max_bookings' => 3, 'duration' => 180],
            'Hair Coloring' => ['max_bookings' => 3, 'duration' => 120],
            'Manicure' => ['max_bookings' => 3, 'duration' => 30],
            'Pedicure' => ['max_bookings' => 3, 'duration' => 45],
            'Facial Treatment' => ['max_bookings' => 5, 'duration' => 60],
            'Hair Spa' => ['max_bookings' => 3, 'duration' => 90],
        ];

        foreach ($servicesData as $serviceName => $data) {
            Service::where('name', 'LIKE', '%' . $serviceName . '%')
                ->update([
                    'max_bookings' => $data['max_bookings'],
                    'duration' => $data['duration']
                ]);
        }

        $this->command->info('Maksimal booking untuk setiap layanan berhasil diatur!');
    }
}
