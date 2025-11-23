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
        Schema::create('sub_bidang_apbdes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_apbdes_id')
                ->constrained('bidang_apbdes')
                ->cascadeOnDelete();
            $table->string('kode_sub_bidang', 15)->unique(); // Contoh: BPD01.001
            $table->string('nama_sub_bidang');
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
        Schema::dropIfExists('sub_bidang_apbdes');
    }
};
