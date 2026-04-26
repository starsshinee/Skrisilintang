<?php
// database/migrations/xxxx_xx_xx_create_user_profiles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_lengkap')->nullable();
            $table->string('instansi')->nullable();
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat_instansi')->nullable();
            $table->string('avatar')->nullable();
            $table->string('signature')->nullable();
            $table->string('signature_mime')->nullable();
            $table->integer('signature_size')->nullable();
            $table->integer('profile_completeness')->default(0);
            $table->timestamps();
            
            $table->unique('user_id');
            $table->index(['nama_lengkap', 'nip', 'instansi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};