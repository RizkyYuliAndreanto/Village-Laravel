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
        Schema::create('laporan_apbdes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_id');
            $table->foreign('tahun_id')
                ->references('id_tahun')  // Kolom di tabel tahun_data
                ->on('tahun_data')        // Nama tabel yang benar
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('nama_laporan'); // Cth: "APBDES 2024", "Perubahan APBDES 2024"
            $table->integer('bulan_rilis'); // Disimpan sebagai angka (1-12)
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('draft'); // Cth: 'draft', 'diterbitkan'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_apbdes');
    }
};
