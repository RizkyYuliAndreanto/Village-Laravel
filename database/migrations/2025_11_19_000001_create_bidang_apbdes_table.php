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
        Schema::create('bidang_apbdes', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bidang', 10)->unique(); // Contoh: BPD01, BPP01
            $table->string('nama_bidang');
            $table->string('kategori'); // 'pendapatan' atau 'belanja'
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_apbdes');
    }
};
