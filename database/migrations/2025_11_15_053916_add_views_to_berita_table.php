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
        Schema::table('berita', function (Blueprint $table) {
            // Tambahkan kolom 'views'
            // Kita gunakan unsignedInteger agar nilainya selalu positif
            // Kita beri default 0 agar data lama tidak null
            $table->unsignedInteger('views')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn('views');
        });
    }
};