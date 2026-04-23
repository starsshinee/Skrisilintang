<?php
// 0001_01_01_000017_create_pengembalian_barang_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pengembalian_barang')) {
            return;
        }

        Schema::create('pengembalian_barang', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('peminjaman_barang_id')->constrained('peminjaman_barang')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // ✅ ADMIN ASET TETAP VERIFIKASI
            $table->foreignId('verified_by_adminAsetTetap_id')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('komentar_admin')->nullable();
            
            // Data Pengembalian
            $table->datetime('tanggal_pengembalian_aktual');
            $table->integer('jumlah_dikembalikan');
            $table->text('kondisi_barang');
            $table->text('catatan')->nullable();
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            
            $table->enum('status_pengembalian', [
                'lengkap', 'rusak_ringan', 'rusak_berat', 'hilang'
            ])->default('lengkap');
            
            $table->enum('status_verifikasi', [
                'pending', 'diterima', 'ditolak'
            ])->default('pending');
            
            $table->timestamps();
            
            // ✅ INDEX PENDEK (FIX ERROR 64 chars)
            $table->index('peminjaman_barang_id', 'idx_pb_id');
            $table->index('status_verifikasi', 'idx_pb_verif');
            $table->index('status_pengembalian', 'idx_pb_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_barang');
    }
};