<?php
// 0001_01_01_000018_create_pengembalian_kendaraan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pengembalian_kendaraan')) {
            return;
        }

        Schema::create('pengembalian_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_kendaraan_id');
            $table->foreign('peminjaman_kendaraan_id')->references('id')->on('peminjaman_kendaraan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('verified_by_admin_id')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('komentar_admin')->nullable();
            $table->datetime('tanggal_pengembalian_aktual');
            $table->text('kondisi_kendaraan');
            $table->text('catatan')->nullable();
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            $table->decimal('biaya_denda', 10, 2)->default(0);
            $table->enum('status_pengembalian', [
                'diproses', 'diterima', 'ditolak'
            ])->default('diproses');
            $table->timestamps();
        });

        DB::statement('CREATE INDEX idx_pk_peminjaman ON pengembalian_kendaraan (peminjaman_kendaraan_id)');
        DB::statement('CREATE INDEX idx_pk_status ON pengembalian_kendaraan (status_pengembalian)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_kendaraan');
    }
};