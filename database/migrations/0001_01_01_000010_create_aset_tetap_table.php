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
            $table->date('tanggal_input');
            $table->string('kode_barang')->unique();
            $table->string('nup')->unique();
            $table->string('nama_barang');
            $table->date('tanggal_perolehan')->nullable();
            $table->integer('jumlah')->default(0);
            $table->string('lokasi')->nullable(); // aktif, nonaktif, rusak
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat'])->nullable(); // baik, rusak, hilang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_tetap');
    }
};
