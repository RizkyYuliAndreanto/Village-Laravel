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
        Schema::create('pekerjaan_statistik', function (Blueprint $table) {
            $table->id('id_pekerjaan'); // increments("id_pekerjaan").primary()
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('tidak_sekolah')->default(0)->nullable(false);
            $table->integer('petani')->default(0)->nullable(false);
            $table->integer('pelajar_mahasiswa')->default(0)->nullable(false);
            $table->integer('pegawai_swasta')->default(0)->nullable(false);
            $table->integer('wiraswasta')->default(0)->nullable(false);
            $table->integer('ibu_rumah_tangga')->default(0)->nullable(false);
            $table->integer('belum_bekerja')->default(0)->nullable(false);
            $table->integer('lainnya')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaan_statistik');
    }
};
