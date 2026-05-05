<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->foreignId('persediaan_id')->constrained('persediaan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah_diminta');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_dibutuhkan')->nullable();
            $table->text('tujuan_penggunaan')->nullable();
            
            
            // Workflow fields
            $table->foreignId('reviewed_by_adminpersediaan_id')->nullable()->constrained('users');
            $table->foreignId('approved_by_kasubag_id')->nullable()->constrained('users');
            $table->enum('status', ['pending', 'dalam_review', 'disetujui_kasubag', 'disetujui', 'ditolak' , 'dibatalkan'])->default('pending');
            $table->string('surat_bast_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_persediaan');
    }
};
