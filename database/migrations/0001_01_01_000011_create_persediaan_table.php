<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori', 20);
            $table->string('kategori', 100);
            $table->string('kode_barang', 50);
            $table->string('nama_barang', 200);
            $table->date('tanggal_masuk');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('harga_total', 15, 2);
            $table->integer('jumlah')->default(0);
            $table->timestamps();

            $table->index(['kode_kategori', 'kode_barang']);
            $table->index('tanggal_masuk');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persediaan');
    }
};
