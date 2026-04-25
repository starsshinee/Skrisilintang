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
            
            // Sesuai kolom tabel: No (auto increment)
            $table->string('nomor_transaksi')->unique();
            
            // Kolom sesuai header tabel
            $table->date('tanggal_input');           // Tanggal Input
            $table->string('kota_kategori');         // Kota Kategori
            $table->string('kategori');              // Kategori
            $table->string('kode_barang');           // Kode Barang
            $table->string('nama_barang');           // Nama Barang
            $table->integer('jumlah_keluar');        // Jumlah Keluar
            $table->decimal('harga', 15, 2);         // Harga
            $table->decimal('total', 15, 2);         // Total
            
            // Relasi (opsional, bisa dihapus jika tidak digunakan)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            
            $table->timestamps();
            
            // Index sesuai kolom utama tabel
            $table->index(['tanggal_input']);
            $table->index(['kota_kategori', 'kategori']);
            $table->index('kode_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluar_persediaan');
    }
};