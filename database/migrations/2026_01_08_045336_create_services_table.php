<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel ini menyimpan data layanan salon:
     * - Potong rambut, Creambath, Smoothing, dll
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Nama layanan: "Potong Rambut"
            $table->text('description');  // Deskripsi lengkap layanan
            $table->decimal('price', 10, 2);  // Harga: 50000.00
            $table->integer('duration')->nullable()->comment('Durasi dalam menit');  // 30, 45, 60, etc
            $table->string('image')->nullable();  // Path gambar (optional)
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};