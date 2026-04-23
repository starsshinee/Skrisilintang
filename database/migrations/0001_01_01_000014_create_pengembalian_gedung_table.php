<?php
// database/migrations/xxxx_xx_xx_create_pengembalian_gedungs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengembalian_gedung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_gedung_id')->constrained('peminjaman_gedung')->onDelete('cascade');
            $table->date('tanggal_pengembalian');
            $table->time('jam_pengembalian');
            $table->enum('kondisi_gedung', ['baik', 'ringan', 'rusak'])->default('baik');
            $table->text('catatan_pengembalian');
            $table->json('foto_kondisi')->nullable(); // Array path foto
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->decimal('denda_akhir', 12, 2)->default(0);
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengembalian_gedungs');
    }
};