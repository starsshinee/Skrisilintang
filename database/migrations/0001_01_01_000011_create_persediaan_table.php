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
            $table->string('kode_kategori');
            $table->string('kategori');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->decimal('harga_total', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persediaan');
    }
};
