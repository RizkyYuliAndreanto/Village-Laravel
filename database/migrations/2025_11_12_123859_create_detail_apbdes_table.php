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
        Schema::create('detail_apbdes', function (Blueprint $table) {
            $table->id();

            // Kunci asing ke laporan utamanya
            $table->foreignId('laporan_apbdes_id')
                ->constrained('laporan_apbdes')
                ->cascadeOnDelete(); // Jika laporan dihapus, detailnya ikut terhapus

            // Tipe: 'pendapatan', 'belanja', atau 'pembiayaan'
            $table->string('tipe');

            // Uraian/Nama: (Mis: 'Pendapatan Asli Desa', 'Belanja Pegawai', 'Penerimaan Pinjaman')
            $table->string('uraian');

            // Menggunakan decimal untuk nilai uang agar presisi
            $table->decimal('anggaran', 15, 2)->default(0);
            $table->decimal('realisasi', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_apbdes');
    }
};
