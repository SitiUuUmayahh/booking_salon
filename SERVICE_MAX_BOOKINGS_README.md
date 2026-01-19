# Service Max Bookings - Dokumentasi

## Deskripsi
Fitur ini mengatur maksimal jumlah booking yang dapat dilakukan untuk setiap layanan salon dalam satu slot waktu. Hal ini penting untuk memastikan kualitas layanan dan menghindari overbooking.

## Konfigurasi Maksimal Booking per Layanan

| Layanan | Durasi | Maksimal Booking | Keterangan |
|---------|--------|------------------|------------|
| Potong Rambut | 30 menit | 6 orang | Layanan cepat dengan kapasitas tinggi |
| Creambath | 45 menit | 6 orang | Dapat melayani beberapa pelanggan bersamaan |
| Smoothing | 3 jam | 3 orang | Membutuhkan waktu lama dan perhatian khusus |
| Hair Coloring | 2 jam | 3 orang | Proses pewarnaan memerlukan waktu dan ketelitian |
| Manicure | 30 menit | 3 orang | Meskipun durasi pendek, proses detail memerlukan perhatian |
| Pedicure | 45 menit | 3 orang | Custom design kuku memerlukan waktu lebih lama |
| Facial Treatment | 1 jam | 5 orang | Tergantung kompleksitas treatment (bisa 3-5 orang) |
| Hair Spa | 1.5 jam | 3 orang | Treatment relaksasi memerlukan ruang dan perhatian |

## File yang Dibuat

### 1. Migration: `add_max_bookings_to_services_table.php`
Menambahkan kolom `max_bookings` ke tabel `services` dengan default value 5.

**Lokasi:** `database/migrations/2026_01_19_114236_add_max_bookings_to_services_table.php`

### 2. Seeder: `ServiceMaxBookingsSeeder.php`
Mengisi data maksimal booking untuk setiap layanan sesuai dengan spesifikasi.

**Lokasi:** `database/seeders/ServiceMaxBookingsSeeder.php`

### 3. Model Update: `Service.php`
Menambahkan `max_bookings` ke dalam `$fillable` array.

**Lokasi:** `app/Models/Service.php`

## Cara Menggunakan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=ServiceMaxBookingsSeeder
```

Atau jalankan keduanya sekaligus:
```bash
php artisan migrate --seed
```

### 3. Verifikasi Data
Periksa apakah data sudah tersimpan dengan benar:
```bash
php artisan tinker
>>> \App\Models\Service::all(['name', 'duration', 'max_bookings']);
```

## Implementasi dalam Sistem Booking

### Contoh Pengecekan Kapasitas
```php
// Di controller atau service booking
public function checkAvailability($serviceId, $bookingDate, $bookingTime)
{
    $service = Service::find($serviceId);
    
    // Hitung jumlah booking yang sudah ada di slot waktu tersebut
    $existingBookings = Booking::where('service_id', $serviceId)
        ->where('booking_date', $bookingDate)
        ->where('booking_time', $bookingTime)
        ->where('status', '!=', 'cancelled')
        ->count();
    
    // Cek apakah masih ada kapasitas
    if ($existingBookings >= $service->max_bookings) {
        return false; // Slot penuh
    }
    
    return true; // Masih tersedia
}
```

### Menampilkan Sisa Slot
```php
public function getAvailableSlots($serviceId, $bookingDate, $bookingTime)
{
    $service = Service::find($serviceId);
    
    $existingBookings = Booking::where('service_id', $serviceId)
        ->where('booking_date', $bookingDate)
        ->where('booking_time', $bookingTime)
        ->where('status', '!=', 'cancelled')
        ->count();
    
    $availableSlots = $service->max_bookings - $existingBookings;
    
    return [
        'total_capacity' => $service->max_bookings,
        'booked' => $existingBookings,
        'available' => $availableSlots,
        'is_full' => $availableSlots <= 0
    ];
}
```

## Catatan Penting

1. **Facial Treatment**: Maksimal booking disetel ke 5 orang, namun bisa disesuaikan menjadi 3 orang untuk treatment yang lebih kompleks. Anda bisa menambahkan logika tambahan berdasarkan tipe treatment.

2. **Flexible Capacity**: Jika diperlukan, Anda bisa menambahkan fitur untuk mengubah kapasitas secara dinamis berdasarkan:
   - Hari dan jam operasional (weekend vs weekday)
   - Jumlah staff yang tersedia
   - Tipe treatment spesifik

3. **Database Index**: Pertimbangkan untuk menambahkan index pada kolom yang sering diquery:
```php
// Dalam migration
$table->index(['service_id', 'booking_date', 'booking_time', 'status']);
```

## Troubleshooting

### Error: Column not found
Pastikan sudah menjalankan migration:
```bash
php artisan migrate:fresh
```

### Data tidak terupdate
Jalankan ulang seeder:
```bash
php artisan db:seed --class=ServiceMaxBookingsSeeder
```

### Perlu reset semua data
```bash
php artisan migrate:fresh --seed
```

## Update di Masa Depan

Jika perlu mengubah kapasitas, Anda bisa:
1. Update langsung di database
2. Buat seeder baru
3. Buat interface admin untuk mengatur kapasitas secara dinamis
