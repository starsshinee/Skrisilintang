<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('permintaan_persediaan', function (Blueprint $table) {
            $table->string('surat_bast_path')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('permintaan_persediaan', function (Blueprint $table) {
            $table->dropColumn('surat_bast_path');
        });
    }
};
