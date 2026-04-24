<?php
// database/migrations/xxxx_xx_xx_create_transaksi_masuk_aset_tetap_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi_masuk_aset_tetap', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('aset_tetap_id')->nullable()->constrained('aset_tetap')->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_barang');
            $table->string('nup')->unique();
            $table->string('nama_barang');
            $table->string('merek')->nullable();
            $table->string('kategori');
            $table->date('tanggal_perolehan');
            $table->decimal('nilai_perolehan', 15, 2);
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_layak_operasi'])->default('baik');
            $table->string('lokasi');
            $table->integer('jumlah')->default(1);
            $table->string('supplier')->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['kode_barang', 'nup']);
            $table->index('tanggal_perolehan');
            $table->index('kondisi');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_masuk_aset_tetap');
    }
};