<?php
// database/migrations/xxxx_create_transaksi_keluar_aset_tetap_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transaksi_keluar_aset_tetap')) {
            return;
        }

        Schema::create('transaksi_keluar_aset_tetap', function (Blueprint $table) {
            $table->id();
            
            // Nomor transaksi unik
            $table->string('nomor_transaksi')->unique();
            
            // Relasi
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Utama (SESUAI TABEL)
            $table->string('kode_barang');
            $table->string('nup');
            $table->string('nama_barang');
            $table->string('merek')->nullable();
            
            // Tanggal & Nilai
            $table->date('tanggal_perolehan');
            $table->decimal('nilai_perolehan', 15, 2)->nullable();
            
            // Lokasi & SK
            $table->string('lokasi');
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            
            // Keterangan
            $table->text('keterangan')->nullable();
            
            // Tambahan
            $table->string('penerima')->nullable();
            $table->string('alasan_keluar')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['kode_barang', 'nup']);
            $table->index('tanggal_perolehan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluar_aset_tetap');
    }
};