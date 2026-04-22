<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_masuk_persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('persediaan_id')->constrained('persediaan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->string('supplier')->nullable();
            $table->string('nomor_referensi')->nullable(); // nomor PO, nomor faktur, dll
            $table->integer('jumlah_masuk');
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuk_persediaan');
    }
};
