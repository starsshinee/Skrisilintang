<?php
// database/migrations/xxxx_create_transaksi_keluar_persediaan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transaksi_keluar_persediaan')) {
            return;
        }

        Schema::create('transaksi_keluar_persediaan', function (Blueprint $table) {
            $table->id();
            
            // Nomor transaksi unik
            $table->string('nomor_transaksi')->unique();
            
            // Relasi
            $table->foreignId('persediaan_id')->constrained('persediaan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Utama (SESUAI TABEL)
            $table->string('kode_kategori');  // "Kota Kategori" → typo? 
            $table->string('kategori');
            $table->string('kode_barang');
            $table->string('nama_barang');
            
            // Jumlah & Harga
            $table->integer('jumlah_keluar');
            $table->decimal('harga', 15, 2)->nullable();  // "Harga" sesuai tabel
            
            // Total (computed)
            $table->decimal('total', 15, 2)->nullable();
            
            // Tambahan
            $table->date('tanggal_keluar');
            $table->string('penerima')->nullable();
            $table->string('tujuan')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['kode_kategori', 'kode_barang']);
            $table->index('tanggal_keluar');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluar_persediaan');
    }
};