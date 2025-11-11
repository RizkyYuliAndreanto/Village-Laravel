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
        Schema::create('tahun_data', function (Blueprint $table) {
            $table->id('id_tahun'); // increments("id_tahun").primary() -> default name is 'id'
            $table->integer('tahun')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_data');
    }
};
