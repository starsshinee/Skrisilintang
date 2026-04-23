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
            
            // Nomor transaksi unik
            $table->string('nomor_transaksi')->unique();
            
            // Relasi
            $table->foreignId('persediaan_id')->constrained('persediaan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Utama (SESUAI TABEL)
            $table->string('kode_kategori');
            $table->string('kategori');
            $table->string('kode_barang');
            $table->string('nama_barang');
            
            // Jumlah & Harga
            $table->integer('jumlah_masuk');
            $table->decimal('harga_satuan', 15, 2)->nullable();
            
            // Total (computed)
            $table->decimal('total', 15, 2)->nullable();
            
            // Tambahan
            $table->date('tanggal_masuk');
            $table->string('supplier')->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['kode_kategori', 'kode_barang']);
            $table->index('tanggal_masuk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuk_persediaan');
    }
};