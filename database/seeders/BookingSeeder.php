<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::where('role', 'user')->get();
        $services = \App\Models\Service::all();

        if ($users->count() === 0 || $services->count() === 0) {
            $this->command->info('No users or services found. Please run user and service seeders first.');
            return;
        }

        foreach ($users as $user) {
            // Create 3-5 random bookings for each user
            $bookingCount = rand(3, 5);
            
            for ($i = 0; $i < $bookingCount; $i++) {
                $service = $services->random();
                $bookingDate = now()->subDays(rand(0, 30))->addDays(rand(0, 60));
                
                $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                $status = $statuses[array_rand($statuses)];
                
                \App\Models\Booking::create([
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'customer_name' => $user->name,
                    'booking_date' => $bookingDate->toDateString(),
                    'booking_time' => sprintf('%02d:00:00', rand(9, 17)), // 9AM to 5PM
                    'status' => $status,
                    'notes' => 'Sample booking untuk ' . $service->name,
                ]);
            }
        }
    }
}
