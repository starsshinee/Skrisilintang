<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman_gedung', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum_lunas', 'lunas'])->default('belum_lunas')->after('status');
            $table->enum('cara_pembayaran', ['tunai', 'transfer'])->default('tunai')->after('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_gedung', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'cara_pembayaran']);
        });
    }
};
