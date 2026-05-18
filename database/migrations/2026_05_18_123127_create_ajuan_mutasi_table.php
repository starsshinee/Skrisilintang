<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ajuan_mutasi')) {
            return;
        }

        Schema::create('ajuan_mutasi', function (Blueprint $table) {
            $table->id();
            
            // Relasi
            $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Utama
            $table->string('kode_barang');
            $table->string('nup')->nullable();     // ✅ Disarankan nullable
            $table->string('nama_barang');
            
            // Lokasi dan kondisi
            $table->string('lokasi_awal');
            $table->string('lokasi_akhir');
            $table->string('kondisi')->nullable(); // ✅ Disarankan nullable
            
            // Tanggal dan Keterangan
            $table->date('tanggal_mutasi');
            $table->text('keterangan')->nullable(); // ✅ UBAH: Jadi text() dan nullable() sesuai controller
            
            $table->timestamps();
        });
            
        // INDEX DENGAN NAMA PENDEK (✅ Anti error MySQL)
        Schema::table('ajuan_mutasi', function (Blueprint $table) {
            $table->index('kode_barang', 'idx_kode');
            $table->index('tanggal_mutasi', 'idx_tgl');
            $table->index(['lokasi_awal', 'lokasi_akhir'], 'idx_lokasi');
            $table->index(['kode_barang', 'tanggal_mutasi'], 'idx_kode_tgl');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajuan_mutasi');
    }
};