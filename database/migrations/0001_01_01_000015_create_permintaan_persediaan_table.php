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
            $table->string('nomor_permintaan')->unique();
            $table->foreignId('persediaan_id')->constrained('persediaan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah_diminta');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_dibutuhkan')->nullable();
            $table->text('keperluan')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_persediaan');
    }
};
