<?php
// database/migrations/xxxx_create_mutasi_barang_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mutasi_barang')) {
            return;
        }

        Schema::create('mutasi_barang', function (Blueprint $table) {
            $table->id();
            
            // Nomor mutasi unik
            $table->string('nomor_mutasi')->unique();
            
            // Relasi
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Utama (SESUAI TABEL)
            $table->string('kode_barang');
            $table->string('nama_barang');
            
            // Lokasi
            $table->string('lokasi_awal');
            $table->string('lokasi_akhir');
            
            // Tanggal
            $table->date('tanggal_mutasi');
            
            // Tambahan
            $table->text('alasan_mutasi')->nullable();
            $table->string('penerima')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('kode_barang');
            $table->index('tanggal_mutasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_barang');
    }
};