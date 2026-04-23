<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_gedung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_gedung');
            $table->string('foto_gedung')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->decimal('luas_bangunan', 10, 2);
            $table->integer('kapasitas');
            $table->json('fasilitas')->nullable();
            $table->decimal('tarif_sewa', 12, 2);
            $table->enum('ketersediaan', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            
            // Workflow fields
            $table->foreignId('reviewed_by_adminsarpras_id')->nullable()->constrained('users');
            $table->foreignId('approved_by_kasubag_id')->nullable()->constrained('users');
            $table->enum('status', ['pending', 'dalam_review', 'disetujui_kasubag', 'disetujui', 'ditolak'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_gedung');
    }
};
