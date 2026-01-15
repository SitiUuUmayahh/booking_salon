<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DATABASE DATA CHECK ===');
        
        $servicesCount = \App\Models\Service::count();
        $this->info("Services count: {$servicesCount}");
        
        if ($servicesCount > 0) {
            $this->info("Services available:");
            \App\Models\Service::take(3)->get()->each(function($service) {
                $this->info("- {$service->name} (Rp " . number_format($service->price) . ")");
            });
        }
        
        $usersCount = \App\Models\User::where('role', 'user')->count();
        $this->info("Customer users count: {$usersCount}");
        
        $bookingsCount = \App\Models\Booking::count();
        $this->info("Bookings count: {$bookingsCount}");
        
        if ($bookingsCount > 0) {
            $this->info("Recent bookings:");
            \App\Models\Booking::with(['user', 'service'])->latest()->take(3)->get()->each(function($booking) {
                $this->info("- {$booking->user->name} booked {$booking->service->name} on {$booking->booking_date}");
            });
        }
    }
}
