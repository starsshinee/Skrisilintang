<?php
// database/migrations/xxxx_create_transaksi_masuk_persediaan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transaksi_masuk_persediaan')) {
            return;
        }

        Schema::create('transaksi_masuk_persediaan', function (Blueprint $table) {
            $table->id();
            
            // Kolom sesuai header tabel HTML
            $table->date('tanggal_input'); // Tanggal Input
            $table->string('kode_kategori', 20); // Kode Kategori
            $table->string('kategori', 100); // Kategori
            $table->string('kode_barang', 50); // Kode Barang
            $table->string('nama_barang', 200); // Nama Barang
            $table->integer('jumlah_masuk'); // Jumlah Masuk
            $table->decimal('harga_satuan', 15, 2); // Harga Satuan
            $table->decimal('total', 15, 2); // Total
            
            // Kolom tambahan untuk tracking
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('created_by')->nullable();
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index(['tanggal_input']);
            $table->index(['kode_kategori', 'kode_barang']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuk_persediaan');
    }
};