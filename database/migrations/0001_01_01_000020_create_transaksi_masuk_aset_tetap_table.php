<?php
// database/migrations/xxxx_create_transaksi_masuk_aset_tetap_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transaksi_masuk_aset_tetap')) {
            return;
        }

        Schema::create('transaksi_masuk_aset_tetap', function (Blueprint $table) {
            $table->id();
            
            // Nomor transaksi unik
            $table->string('nomor_transaksi')->unique();
            
            // Relasi
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Utama (SESUAI TABEL)
            $table->string('kode_barang');
            $table->string('nup')->unique();
            $table->string('nama_barang');
            $table->string('merek')->nullable();
            $table->string('kategori');
            
            // Tanggal & Nilai
            $table->date('tanggal_perolehan');
            $table->decimal('nilai_perolehan', 15, 2)->nullable();
            
            // Kondisi & Lokasi
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak_operasi'])->default('baik');
            $table->string('lokasi');
            
            // Jumlah
            $table->integer('jumlah')->default(1);
            
            // Tambahan
            $table->string('supplier')->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['kode_barang', 'nup']);
            $table->index('tanggal_perolehan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuk_aset_tetap');
    }
};