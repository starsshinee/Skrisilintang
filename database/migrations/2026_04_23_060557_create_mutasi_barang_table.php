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
            
            // Relasi
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Utama
            $table->string('kode_barang');
            $table->string('nama_barang');
            
            // Lokasi
            $table->string('lokasi_awal');
            $table->string('lokasi_akhir');
            
            // Tanggal
            $table->date('tanggal_mutasi');
            
            $table->timestamps();
        });
            
            // INDEX DENGAN NAMA PENDEK (✅ Anti error MySQL)
        Schema::table('mutasi_barang', function (Blueprint $table) {
            $table->index('kode_barang', 'idx_kode');
            $table->index('tanggal_mutasi', 'idx_tgl');
            $table->index(['lokasi_awal', 'lokasi_akhir'], 'idx_lokasi');
            $table->index(['kode_barang', 'tanggal_mutasi'], 'idx_kode_tgl');
        });
        
    }

    
    public function down(): void
    {
        Schema::dropIfExists('mutasi_barang');
    }
};