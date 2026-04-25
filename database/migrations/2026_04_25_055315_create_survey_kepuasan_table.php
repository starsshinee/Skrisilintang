<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('survey_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->enum('kepuasan', ['sangat_puas', 'puas', 'cukup', 'kurang_puas', 'tidak_puas']);
            $table->text('aspek_memuaskan')->nullable();
            $table->text('saran')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['kepuasan', 'created_at']);
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('survey_kepuasan');
    }
};