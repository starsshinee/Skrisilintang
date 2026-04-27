<?php
// Lengkapi migration yang terpotong
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_gedung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Data peminjam
            $table->string('nama_lengkap');
            $table->string('nip_nik');
            $table->string('instansi_lembaga');
            $table->string('kabupaten_kota');
            
            // Data fasilitas + TARIF
            $table->string('fasilitas'); 
            $table->string('nama_fasilitas')->nullable();
            $table->decimal('tarif_per_hari', 15, 2); // Tarif per hari dari fasilitas
            
            // Data waktu peminjaman
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('lama_peminjaman_hari')->default(1); // Auto calculated
            
            // Data pembayaran (AUTO CALCULATED)
            $table->decimal('total_pembayaran', 15, 2)->default(0);
            
            // Status pembayaran & cara pembayaran (BARU)
            $table->enum('status_pembayaran', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->enum('cara_pembayaran', ['tunai', 'transfer'])->default('tunai');
            
            // Lainnya
            $table->text('tujuan_penggunaan');
            $table->string('nomor_kontak');
            $table->string('surat_path')->nullable();
            
            // Workflow
            $table->enum('status', ['pending', 'dalam_review', 'disetujui_kasubag', 'disetujui', 'ditolak'])->default('pending');
            $table->text('komentar')->nullable();
            $table->foreignId('reviewed_by_admin_id')->nullable()->constrained('users');
            $table->timestamp('tanggal_approval')->nullable();
            $table->foreignId('approved_by_kasubag_id')->nullable()->constrained('users');
            $table->timestamp('approved_by_kasubag_date')->nullable();
            $table->timestamp('diteruskan_ke_kasubag_date')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_gedung');
    }
};