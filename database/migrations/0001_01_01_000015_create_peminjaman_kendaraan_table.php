<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // php artisan make:migration create_peminjaman_kendaraan_table
Schema::create('peminjaman_kendaraan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    
    $table->string('nama_barang');
    $table->string('kode_barang')->nullable();
    $table->string('nup')->nullable();
    $table->string('merek')->nullable();
    $table->integer('jumlah');
    $table->text('deskripsi_peruntukan');
    $table->string('surat_bast_path')->nullable();
    
    $table->dateTime('request_date')->nullable();
    $table->date('tanggal_peminjaman')->nullable();
    $table->date('tanggal_pengembalian')->nullable();
    $table->text('komentar')->nullable();
    
    // Workflow fields (sama persis dengan peminjaman_barang)
    $table->foreignId('reviewed_by_adminasettetap_id')->nullable()->constrained('users');
    $table->foreignId('approved_by_adminasettetap_id')->nullable()->constrained('users');
    $table->foreignId('approved_by_kasubag_id')->nullable()->constrained('users');
    $table->enum('status', ['pending', 'dalam_review', 'disetujui_admin', 'disetujui', 'ditolak'])->default('pending');
    $table->dateTime('diteruskan_ke_kasubag_date')->nullable();
    $table->dateTime('approved_by_kasubag_date')->nullable();
    
    $table->timestamps();
    });
    
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_kendaraan');
    }
};
