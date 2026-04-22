<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_peminjaman')->unique();
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai_direncanakan')->nullable();
            $table->string('tujuan');
            $table->string('sopir')->nullable();
            $table->decimal('jumlah_bahan_bakar', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('pending'); // pending, approved, digunakan, dikembalikan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_kendaraan');
    }
};
