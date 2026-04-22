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
            $table->string('kode_gedung')->unique();
            $table->string('nama_gedung');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->decimal('luas_bangunan', 10, 2)->nullable();
            $table->string('tipe_ruang')->nullable(); // aula, ruang meeting, studio, dll
            $table->integer('kapasitas')->nullable();
            $table->text('fasilitas')->nullable();
            $table->string('status')->default('aktif'); // aktif, nonaktif, sedang diperbaiki
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gedung');
    }
};
