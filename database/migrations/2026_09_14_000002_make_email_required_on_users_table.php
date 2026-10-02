<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill: pastikan tidak ada user tanpa email sebelum kolom dijadikan required.
        DB::table('users')
            ->whereNull('email')
            ->orWhere('email', '')
            ->update([
                'email' => DB::raw("CONCAT(username, '@bpmpgorontalo.id')"),
            ]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }
};