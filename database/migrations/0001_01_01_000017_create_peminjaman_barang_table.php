<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->id();
            
            // Requester
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Barang
            $table->string('nama_barang');
            $table->string('kode_barang')->unique();
            $table->string('nup')->nullable();
            $table->string('kategori');
            $table->string('merek')->nullable();
            $table->integer('jumlah');
            $table->text('deskripsi_peruntukan');
            
            // Tanggal
            $table->date('request_date');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            
            // Workflow Admin Aset Tetap
            $table->foreignId('reviewed_by_adminasettetap_id')->nullable()->constrained('users');
            $table->foreignId('approved_by_adminasettetap_id')->nullable()->constrained('users');
            
            // Workflow Kasubag
            $table->timestamp('diteruskan_ke_kasubag_date')->nullable();
            $table->foreignId('approved_by_kasubag_id')->nullable()->constrained('users');
            $table->timestamp('approved_by_kasubag_date')->nullable();
            
            $table->text('komentar')->nullable();
            $table->enum('status', [
                'pending', 'dalam_review', 'disetujui_admin', 
                'diteruskan_kasubag', 'disetujui', 'ditolak'
            ])->default('pending');
            $table->string('surat_bast_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barang');  // ✅ FIX NAMA!
    }
};