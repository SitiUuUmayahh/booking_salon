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
        // List gambar yang tersedia di storage/app/public/services/
        $images = [
            'services/04UNZtN9fZUZCENg9UKgk6HgVOzWOju3A1mBz5Vk.jpg',
            'services/cFVL08wVLck7XNGnoQVAZVwIVOmL8F7BQwVupE6h.jpg',
            'services/cGa4zXDz4HKmFYBhyPcFToR9sW9us4O0HqUAVbbz.jpg',
            'services/GKbbW89h4gjr7vLK2l4L1nOkI7jQtJLsSe8mVX87.jpg',
            'services/KD1P2We29OtlkrkMhQSl604r263CTylV15Vo2nUA.jpg',
            'services/m8tfSyrFNx54kuIEwwbzKAcd5bzjkvTQADh9uAwN.jpg',
            'services/PO7aDk47rifCe9m3LTEm1GZNK8undFSh0NY3cwyr.jpg',
            'services/qTcrVVdyGFnQjEFditbv5vmqW3c5FY7jAAkjtMNO.jpg',
        ];

        $services = [
            [
                'name' => 'Potong Rambut',
                'description' => 'Potong rambut sesuai model yang Anda inginkan dengan stylist berpengalaman. Termasuk keramas dan blow dry.',
                'price' => 50000,
                'duration' => 30,
                'image' => $images[4] ?? null,
            ],
            [
                'name' => 'Creambath',
                'description' => 'Perawatan rambut dengan cream khusus untuk menutrisi dan melembabkan rambut. Termasuk pijat kepala relaksasi.',
                'price' => 75000,
                'duration' => 45,
                'image' => $images[6] ?? null,
            ],
            [
                'name' => 'Smoothing',
                'description' => 'Pelurusan rambut permanen menggunakan produk berkualitas tinggi. Hasil rambut lurus natural hingga 6 bulan.',
                'price' => 500000,
                'duration' => 180,
                'image' => $images[7] ?? null,
            ],
            [
                'name' => 'Hair Coloring',
                'description' => 'Pewarnaan rambut dengan berbagai pilihan warna. Menggunakan cat rambut premium yang aman dan tahan lama.',
                'price' => 350000,
                'duration' => 120,
                'image' => $images[1] ?? null,
            ],
            [
                'name' => 'Manicure',
                'description' => 'Perawatan kuku tangan lengkap. Termasuk potong, rapikan, cat kuku dengan pilihan warna beragam.',
                'price' => 50000,
                'duration' => 30,
                'image' => $images[2] ?? null,
            ],
            [
                'name' => 'Pedicure',
                'description' => 'Perawatan kuku kaki lengkap dengan rendam, scrub, dan pijat kaki. Termasuk cat kuku pilihan.',
                'price' => 50000,
                'duration' => 45,
                'image' => $images[0] ?? null,
            ],
            [
                'name' => 'Facial Treatment',
                'description' => 'Perawatan wajah lengkap dengan facial wash, steam, ekstraksi komedo, masker, dan serum. Untuk semua jenis kulit.',
                'price' => 100000,
                'duration' => 60,
                'image' => $images[3] ?? null,
            ],
            [
                'name' => 'Hair Spa',
                'description' => 'Perawatan rambut premium dengan masker intensif, pijat aromatherapy, dan steam. Untuk rambut rusak dan kering.',
                'price' => 150000,
                'duration' => 90,
                'image' => $images[5] ?? null,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
