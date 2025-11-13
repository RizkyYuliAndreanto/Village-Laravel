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
        Schema::create('dusun_statistik', function (Blueprint $table) {
            $table->id('id_dusun'); // Primary key dengan nama sesuai konvensi
            $table->foreignId('tahun_id') // Foreign key ke tabel tahun_data
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama_dusun', 100)->nullable(false); // Nama dusun
            $table->integer('jumlah_penduduk')->default(0)->nullable(false); // Total penduduk dusun
            $table->integer('jumlah_kk')->default(0)->nullable(false); // Jumlah Kepala Keluarga
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->timestamp('create_at')->useCurrent(); // Timestamp create
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Timestamp update

            // Unique constraint: satu dusun per tahun (nama_dusun + tahun_id harus unik)
            $table->unique(['tahun_id', 'nama_dusun'], 'unique_dusun_per_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dusun_statistik');
    }
};
