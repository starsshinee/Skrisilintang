<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi_keluar_aset_tetap', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_input');
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->string('kode_barang');
            $table->string('nup');
            $table->string('nama_barang');
            $table->string('merek')->nullable();
            $table->date('tanggal_perolehan');
            $table->decimal('nilai_perolehan', 15, 2);
            $table->string('lokasi')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Index untuk performa pencarian
            $table->index(['tanggal_input']);
            $table->index(['kode_barang']);
            $table->index(['nomor_sk']);
            $table->index(['aset_tetap_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_keluar_aset_tetap');
    }
};