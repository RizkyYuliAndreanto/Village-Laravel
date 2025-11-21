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
        Schema::table('detail_apbdes', function (Blueprint $table) {
            // Tambah kolom untuk referensi bidang dan sub bidang
            $table->foreignId('bidang_apbdes_id')
                ->nullable()
                ->after('laporan_apbdes_id')
                ->constrained('bidang_apbdes')
                ->nullOnDelete();

            $table->foreignId('sub_bidang_apbdes_id')
                ->nullable()
                ->after('bidang_apbdes_id')
                ->constrained('sub_bidang_apbdes')
                ->nullOnDelete();

            // Tambah kolom untuk tracking persentase realisasi
            $table->decimal('persentase_realisasi', 5, 2)
                ->nullable()
                ->after('realisasi')
                ->comment('Persentase realisasi dari anggaran');

            // Tambah kolom untuk keterangan
            $table->text('keterangan')->nullable()->after('persentase_realisasi');

            // Tambah kolom untuk bulan realisasi
            $table->integer('bulan_realisasi')
                ->nullable()
                ->after('keterangan')
                ->comment('Bulan data realisasi (1-12)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_apbdes', function (Blueprint $table) {
            $table->dropForeign(['bidang_apbdes_id']);
            $table->dropForeign(['sub_bidang_apbdes_id']);
            $table->dropColumn([
                'bidang_apbdes_id',
                'sub_bidang_apbdes_id',
                'persentase_realisasi',
                'keterangan',
                'bulan_realisasi'
            ]);
        });
    }
};
