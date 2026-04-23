<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gedung');
            $table->string('foto_gedung')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->decimal('luas_bangunan', 10, 2)->nullable();
            $table->integer('kapasitas')->nullable();
            $table->text('fasilitas')->nullable();
            $table->decimal('tarif_sewa', 15, 2)->nullable();
            $table->enum('ketersediaan', ['tersedia', 'tidak tersedia'])->default('tersedia'); // tersedia, tidak tersedia
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gedung');
    }
};
