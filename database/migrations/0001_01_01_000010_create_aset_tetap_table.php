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
            $table->date('tanggal_input')->default(now()->format('Y-m-d'));
            $table->string('kode_barang')->unique();
            $table->string('nup')->unique();
            $table->string('nama_barang');
            $table->string('merek')->nullable();
            $table->string('kategori');
            $table->date('tanggal_perolehan');
            $table->decimal('nilai_perolehan', 15, 2);
            $table->integer('jumlah')->default(1);
            $table->string('lokasi');
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat'])->default('Baik');
            $table->timestamps();
            
            $table->index(['kode_barang', 'nup', 'nama_barang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_tetap');
    }
};