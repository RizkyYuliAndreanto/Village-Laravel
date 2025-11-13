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
        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id('id_struktur'); // increments("id_struktur").primary()
            $table->string('nama')->nullable(false);
            $table->string('jabatan')->nullable(false);
            $table->string('foto_url')->nullable(false);
            $table->text('keterangan')->nullable();
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perhatikan bahwa Knex dropTableIfExists di file aslinya salah ("struktur_organisasi" tidak di-string)
        Schema::dropIfExists('struktur_organisasi');
    }
};
