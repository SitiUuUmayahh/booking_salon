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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('cancel_count')->default(0)->after('role');
            $table->timestamp('last_booking_at')->nullable()->after('cancel_count');
            $table->boolean('is_suspended')->default(false)->after('last_booking_at');
            $table->text('suspend_reason')->nullable()->after('is_suspended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cancel_count', 'last_booking_at', 'is_suspended', 'suspend_reason']);
        });
    }
};
