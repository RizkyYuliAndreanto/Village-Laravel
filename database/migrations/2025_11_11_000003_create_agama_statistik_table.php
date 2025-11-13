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
        Schema::create('agama_statistik', function (Blueprint $table) {
            $table->id('id_agama'); // increments("id_agama").primary()
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('islam')->default(0)->nullable(false);
            $table->integer('katolik')->default(0)->nullable(false);
            $table->integer('kristen')->default(0)->nullable(false);
            $table->integer('hindu')->default(0)->nullable(false);
            $table->integer('buddha')->default(0)->nullable(false);
            $table->integer('konghucu')->default(0)->nullable(false);
            $table->integer('kepercayaan_lain')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agama_statistik');
    }
};
