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
            // Tambahkan kolom 'status'
            // Kita beri default 'published' agar data lama tetap tampil
            // Anda bisa juga menggunakan 'draft' jika lebih aman
            $table->string('status', 50)->default('published')->after('penulis');
            
            // Tambahkan index untuk performa query yang lebih baik
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Hapus index dan kolom jika migrasi di-rollback
            $table->dropIndex(['status']);
            $table->dropColumn('status');
        });
    }
};