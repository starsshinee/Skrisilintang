<?php
// database/migrations/xxxx_xx_xx_create_kerusakans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kerusakan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_input');
            $table->string('nama_barang');
            $table->string('kode_barang')->unique();
            $table->string('nup')->unique();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat', 'Hancur']);
            $table->string('foto')->nullable(); // Path foto
            $table->text('lokasi');
            $table->text('deskripsi')->nullable(); // Tambahan deskripsi kerusakan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kerusakan');
    }
};