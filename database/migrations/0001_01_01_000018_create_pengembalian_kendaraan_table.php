<?php
// 0001_01_01_000017_create_pengembalian_barang_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pengembalian_barang')) {
            return;
        }

        Schema::create('pengembalian_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_barang_id');  // Raw type
            $table->foreign('peminjaman_barang_id')->references('id')->on('peminjaman_barang')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('verified_by_adminAsetTetap_id')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('komentar_admin')->nullable();
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
        });

        // ✅ MANUAL INDEX PENDEK (hindari auto-generated long name)
        DB::statement('CREATE INDEX idx_pb_peminjaman ON pengembalian_barang (peminjaman_barang_id)');
        DB::statement('CREATE INDEX idx_pb_status ON pengembalian_barang (status_pengembalian)');
        DB::statement('CREATE INDEX idx_pb_verif ON pengembalian_barang (status_verifikasi)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_barang');
    }
};