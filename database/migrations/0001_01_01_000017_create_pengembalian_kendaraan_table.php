<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengembalian')->unique();
            $table->foreignId('peminjaman_kendaraan_id')->constrained('peminjaman_kendaraan')->onDelete('cascade');
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('tanggal_pengembalian');
            $table->integer('km_awal')->nullable();
            $table->integer('km_akhir')->nullable();
            $table->string('kondisi'); // baik, rusak, hilang
            $table->text('keterangan_kondisi')->nullable();
            $table->decimal('biaya_perbaikan', 15, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_kendaraan');
    }
};
