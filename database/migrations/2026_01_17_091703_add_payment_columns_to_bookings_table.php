<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Down Payment (DP) columns
            $table->decimal('dp_amount', 10, 2)->default(0)->after('status'); // Jumlah DP yang harus dibayar
            $table->enum('dp_status', ['unpaid', 'pending', 'verified', 'rejected'])
                  ->default('unpaid')
                  ->after('dp_amount'); // Status pembayaran DP
            $table->string('dp_payment_proof')->nullable()->after('dp_status'); // Path foto bukti transfer
            $table->text('dp_rejection_reason')->nullable()->after('dp_payment_proof'); // Alasan jika ditolak admin
            $table->timestamp('dp_paid_at')->nullable()->after('dp_rejection_reason'); // Kapan user upload bukti
            $table->timestamp('dp_verified_at')->nullable()->after('dp_paid_at'); // Kapan admin verify
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'dp_amount',
                'dp_status',
                'dp_payment_proof',
                'dp_rejection_reason',
                'dp_paid_at',
                'dp_verified_at'
            ]);
        });
    }
};
