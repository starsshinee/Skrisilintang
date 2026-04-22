<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengembalian')->unique();
            $table->foreignId('peminjaman_gedung_id')->constrained('peminjaman_gedung')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('tanggal_pengembalian');
            $table->string('kondisi'); // baik, rusak, hilang
            $table->text('keterangan_kondisi')->nullable();
            $table->text('biaya_kerusakan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_barang');
    }
};
