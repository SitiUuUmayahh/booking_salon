<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;


class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Potong Rambut',
                'description' => 'Potong rambut sesuai model yang Anda inginkan dengan stylist berpengalaman. Termasuk keramas dan blow dry.',
                'price' => 50000,
                'duration' => 30,
                'image' => null,
            ],
            [
                'name' => 'Creambath',
                'description' => 'Perawatan rambut dengan cream khusus untuk menutrisi dan melembabkan rambut. Termasuk pijat kepala relaksasi.',
                'price' => 75000,
                'duration' => 45,
                'image' => null,
            ],
            [
                'name' => 'Smoothing',
                'description' => 'Pelurusan rambut permanen menggunakan produk berkualitas tinggi. Hasil rambut lurus natural hingga 6 bulan.',
                'price' => 500000,
                'duration' => 180,
                'image' => null,
            ],
            [
                'name' => 'Hair Coloring',
                'description' => 'Pewarnaan rambut dengan berbagai pilihan warna. Menggunakan cat rambut premium yang aman dan tahan lama.',
                'price' => 350000,
                'duration' => 120,
                'image' => null,
            ],
            [
                'name' => 'Manicure',
                'description' => 'Perawatan kuku tangan lengkap. Termasuk potong, rapikan, cat kuku dengan pilihan warna beragam.',
                'price' => 50000,
                'duration' => 30,
                'image' => null,
            ],
            [
                'name' => 'Pedicure',
                'description' => 'Perawatan kuku kaki lengkap dengan rendam, scrub, dan pijat kaki. Termasuk cat kuku pilihan.',
                'price' => 50000,
                'duration' => 45,
                'image' => null,
            ],
            [
                'name' => 'Facial Treatment',
                'description' => 'Perawatan wajah lengkap dengan facial wash, steam, ekstraksi komedo, masker, dan serum. Untuk semua jenis kulit.',
                'price' => 100000,
                'duration' => 60,
                'image' => null,
            ],
            [
                'name' => 'Hair Spa',
                'description' => 'Perawatan rambut premium dengan masker intensif, pijat aromatherapy, dan steam. Untuk rambut rusak dan kering.',
                'price' => 150000,
                'duration' => 90,
                'image' => null,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
