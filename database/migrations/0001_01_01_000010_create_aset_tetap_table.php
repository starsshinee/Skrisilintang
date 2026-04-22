<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_tetap', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->integer('jumlah')->default(0);
            $table->string('lokasi')->nullable();
            $table->decimal('nilai_awal', 15, 2)->nullable();
            $table->decimal('nilai_sekarang', 15, 2)->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->string('status')->default('aktif'); // aktif, nonaktif, rusak
            $table->string('kondisi')->nullable(); // baik, rusak, hilang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_tetap');
    }
};
