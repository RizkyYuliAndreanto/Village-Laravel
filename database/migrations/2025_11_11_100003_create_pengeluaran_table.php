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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id(); // increments("id").primary()
            $table->foreignId('tahun_id')
                ->unsigned()
                ->nullable(false)
                ->references('id_tahun')
                ->on('tahun_data')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('kategori')->nullable(false);
            $table->string('nama_rincian')->nullable(false);
            $table->decimal('jumlah', 15, 2)->nullable(false); // Menggunakan presisi 15 dan skala 2 untuk decimal
            $table->text('keterangan')->nullable();
            $table->timestamp('create_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
