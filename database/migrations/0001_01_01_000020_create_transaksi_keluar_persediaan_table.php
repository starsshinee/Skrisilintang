<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_keluar_persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('persediaan_id')->constrained('persediaan')->onDelete('cascade');
            $table->foreignId('permintaan_persediaan_id')->nullable()->constrained('permintaan_persediaan')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_keluar');
            $table->integer('jumlah_keluar');
            $table->string('penerima')->nullable();
            $table->string('tujuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluar_persediaan');
    }
};
