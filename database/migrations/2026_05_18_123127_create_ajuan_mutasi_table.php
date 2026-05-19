<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        // Langsung buat tabel, tidak perlu if (Schema::hasTable) karena RefreshDatabase sudah menangani semuanya
        public function up(): void
    {
        // Cukup gunakan Schema::create saja
        Schema::create('ajuan_mutasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  
            
            $table->string('kode_barang');
            $table->string('nup')->nullable();
            $table->string('nama_barang');
            $table->string('lokasi_awal');
            $table->string('lokasi_akhir');
            $table->string('kondisi')->nullable();
            $table->date('tanggal_mutasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // GANTI INI: Gunakan array index tanpa nama kustom
            $table->index('kode_barang');
            $table->index('tanggal_mutasi');
            $table->index(['lokasi_awal', 'lokasi_akhir']);
            $table->index(['kode_barang', 'tanggal_mutasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajuan_mutasi');
    }
};