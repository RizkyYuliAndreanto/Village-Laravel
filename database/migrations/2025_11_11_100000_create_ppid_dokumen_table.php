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
        Schema::create('ppid_dokumen', function (Blueprint $table) {
            $table->id(); // increments("id").primary()
            $table->string('judul_dokumen')->nullable(false);
            $table->string('file_url')->nullable(false);
            // enum("kategori", [...])
            $table->enum('kategori', ['informasi berkala', 'informasi sertamerta', 'informasi setiap saat', 'informasi dikecualikan'])
                ->default('informasi berkala')
                ->nullable(false);
            $table->integer('tahun')->nullable(false);
            $table->date('tanggal_upload')->nullable(false);
            $table->string('uploader')->nullable(false);
            $table->timestamp('create_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppid_dokumen');
    }
};
