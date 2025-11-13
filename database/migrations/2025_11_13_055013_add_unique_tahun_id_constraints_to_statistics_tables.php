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
        // Tambah unique constraint untuk demografi_penduduk
        Schema::table('demografi_penduduk', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_demografi_tahun_id');
        });

        // Tambah unique constraint untuk umur_statistik
        Schema::table('umur_statistik', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_umur_tahun_id');
        });

        // Tambah unique constraint untuk agama_statistik
        Schema::table('agama_statistik', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_agama_tahun_id');
        });

        // Tambah unique constraint untuk pekerjaan_statistik
        Schema::table('pekerjaan_statistik', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_pekerjaan_tahun_id');
        });

        // Tambah unique constraint untuk pendidikan_statistik
        Schema::table('pendidikan_statistik', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_pendidikan_tahun_id');
        });

        // Tambah unique constraint untuk perkawinan_statistik
        Schema::table('perkawinan_statistik', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_perkawinan_tahun_id');
        });

        // Tambah unique constraint untuk wajib_pilih_statistik
        Schema::table('wajib_pilih_statistik', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_wajib_pilih_tahun_id');
        });

        // Tambah unique constraint untuk pendapatan
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_pendapatan_tahun_id');
        });

        // Tambah unique constraint untuk pengeluaran
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->unique('tahun_id', 'unique_pengeluaran_tahun_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus unique constraint dari demografi_penduduk
        Schema::table('demografi_penduduk', function (Blueprint $table) {
            $table->dropUnique('unique_demografi_tahun_id');
        });

        // Hapus unique constraint dari umur_statistik
        Schema::table('umur_statistik', function (Blueprint $table) {
            $table->dropUnique('unique_umur_tahun_id');
        });

        // Hapus unique constraint dari agama_statistik
        Schema::table('agama_statistik', function (Blueprint $table) {
            $table->dropUnique('unique_agama_tahun_id');
        });

        // Hapus unique constraint dari pekerjaan_statistik
        Schema::table('pekerjaan_statistik', function (Blueprint $table) {
            $table->dropUnique('unique_pekerjaan_tahun_id');
        });

        // Hapus unique constraint dari pendidikan_statistik
        Schema::table('pendidikan_statistik', function (Blueprint $table) {
            $table->dropUnique('unique_pendidikan_tahun_id');
        });

        // Hapus unique constraint dari perkawinan_statistik
        Schema::table('perkawinan_statistik', function (Blueprint $table) {
            $table->dropUnique('unique_perkawinan_tahun_id');
        });

        // Hapus unique constraint dari wajib_pilih_statistik
        Schema::table('wajib_pilih_statistik', function (Blueprint $table) {
            $table->dropUnique('unique_wajib_pilih_tahun_id');
        });

        // Hapus unique constraint dari pendapatan
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->dropUnique('unique_pendapatan_tahun_id');
        });

        // Hapus unique constraint dari pengeluaran
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->dropUnique('unique_pengeluaran_tahun_id');
        });
    }
};
