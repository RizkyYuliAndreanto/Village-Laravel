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
        // Cek tabel exist sebelum menambahkan constraint
        if (Schema::hasTable('pendapatan')) {
            Schema::table('pendapatan', function (Blueprint $table) {
                $table->unique('tahun_id', 'unique_pendapatan_tahun_id');
            });
        }

        if (Schema::hasTable('agama_statistik')) {
            Schema::table('agama_statistik', function (Blueprint $table) {
                $table->unique('tahun_id', 'unique_agama_statistik_tahun_id');
            });
        }

        if (Schema::hasTable('usia_statistik')) {
            Schema::table('usia_statistik', function (Blueprint $table) {
                $table->unique('tahun_id', 'unique_usia_statistik_tahun_id');
            });
        }

        if (Schema::hasTable('pekerjaan_statistik')) {
            Schema::table('pekerjaan_statistik', function (Blueprint $table) {
                $table->unique('tahun_id', 'unique_pekerjaan_statistik_tahun_id');
            });
        }

        if (Schema::hasTable('pendidikan_statistik')) {
            Schema::table('pendidikan_statistik', function (Blueprint $table) {
                $table->unique('tahun_id', 'unique_pendidikan_statistik_tahun_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pendapatan')) {
            Schema::table('pendapatan', function (Blueprint $table) {
                $table->dropUnique('unique_pendapatan_tahun_id');
            });
        }

        if (Schema::hasTable('agama_statistik')) {
            Schema::table('agama_statistik', function (Blueprint $table) {
                $table->dropUnique('unique_agama_statistik_tahun_id');
            });
        }

        if (Schema::hasTable('usia_statistik')) {
            Schema::table('usia_statistik', function (Blueprint $table) {
                $table->dropUnique('unique_usia_statistik_tahun_id');
            });
        }

        if (Schema::hasTable('pekerjaan_statistik')) {
            Schema::table('pekerjaan_statistik', function (Blueprint $table) {
                $table->dropUnique('unique_pekerjaan_statistik_tahun_id');
            });
        }

        if (Schema::hasTable('pendidikan_statistik')) {
            Schema::table('pendidikan_statistik', function (Blueprint $table) {
                $table->dropUnique('unique_pendidikan_statistik_tahun_id');
            });
        }
    }
};
