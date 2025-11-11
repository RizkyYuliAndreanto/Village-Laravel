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
        Schema::create('berita', function (Blueprint $table) {
            $table->id(); // increments("id").primary()
            $table->string('judul')->nullable(false);
            $table->text('isi')->nullable(false);
            $table->string('gambar_url')->nullable(false);
            // enum("kegiatan", ["umum", "pengumuman", "kegiatan"]).notNullable().defaultTo("umum")
            $table->enum('kegiatan', ['umum', 'pengumuman', 'kegiatan'])
                ->default('umum')
                ->nullable(false);
            $table->string('penulis')->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
