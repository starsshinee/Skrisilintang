<?php
// database/migrations/xxxx_xx_xx_create_pengaduans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('telepon');
            $table->enum('kategori', [
                'peminjaman_barang', 'pengembalian_barang', 
                'peminjaman_kendaraan', 'pengembalian_kendaraan',
                'peminjaman_gedung', 'pengembalian_gedung',
                'persediaan', 'sistem', 'layanan', 'lainnya'
            ]);
            $table->text('deskripsi');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditolak'])->default('baru');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};