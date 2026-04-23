<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_kendaraan', function (Blueprint $table) {
           $table->id();
    
        // Requester & Asset
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('aset_tetap_id')->constrained('aset_tetap')->onDelete('cascade');
        
        // Data Kendaraan
        $table->string('nama_kendaraan');
        $table->string('kode_barang');
        $table->string('nup');
        $table->string('merek');
        $table->integer('jumlah');
        
        // Detail Peminjaman
        $table->text('tujuan_peminjaman');
        // $table->date('tanggal_mulai');
        // $table->date('tanggal_selesai');
        
        // Tanggal Tracking
        $table->timestamp('tanggal_peminjaman')->nullable();
        $table->timestamp('tanggal_pengembalian')->nullable();
        
        // Workflow Admin Aset Tetap
        $table->foreignId('reviewed_by_adminasettetap_id')->nullable()->constrained('users');
        $table->foreignId('approved_by_adminasettetap_id')->nullable()->constrained('users');
        
        // Workflow Kasubag
        $table->timestamp('diteruskan_ke_kasubag_date')->nullable();
        $table->foreignId('approved_by_kasubag_id')->nullable()->constrained('users');
        $table->timestamp('approved_by_kasubag_date')->nullable();
        
        $table->text('komentar')->nullable();
        
        $table->enum('status', [
            'pending', 
            'dalam_review', 
            'disetujui_admin', 
            'diteruskan_kasubag',
            'disetujui', 
            'sedang_dipakai',
            'dikembalikan',
            'ditolak'
        ])->default('pending');
        
        $table->timestamps();
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_kendaraan');
    }
};
