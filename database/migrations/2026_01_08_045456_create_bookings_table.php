<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel ini menyimpan data booking dari customer:
     * - Data customer, service yang dipilih, tanggal & jam, status
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke user yang booking
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');  // Jika user dihapus, bookingnya ikut terhapus
            
            // Foreign key ke layanan yang dipilih
            $table->foreignId('service_id')
                  ->constrained()
                  ->onDelete('cascade');  // Jika service dihapus, bookingnya ikut terhapus
            
            // Data booking
            $table->string('customer_name');  // Nama customer (bisa beda dengan nama user)
            $table->date('booking_date');  // Tanggal booking: 2026-01-15
            $table->time('booking_time');  // Jam booking: 10:00:00
            $table->text('notes')->nullable();  // Catatan tambahan (optional)
            
            // Status booking
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending');
            /*
             * Status:
             * - pending: Menunggu konfirmasi admin
             * - confirmed: Sudah dikonfirmasi admin
             * - completed: Sudah selesai
             * - cancelled: Dibatalkan
             */
            
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};