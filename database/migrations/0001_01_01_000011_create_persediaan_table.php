<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_persediaan')->unique();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->string('satuan');
            $table->integer('jumlah_stok')->default(0);
            $table->integer('jumlah_minimum')->default(0);
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('status')->default('aktif'); // aktif, nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persediaan');
    }
};
