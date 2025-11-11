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
        Schema::create('apbdes_tahun', function (Blueprint $table) {
            $table->id(); // increments("id").primary()
            $table->integer('tahun')->nullable(false);
            $table->decimal('total_pendapatan', 15, 2)->nullable(false); // Menggunakan presisi 15 dan skala 2 untuk decimal
            $table->decimal('total_pengeluaran', 15, 2)->nullable(false);
            $table->decimal('saldo_akhir', 15, 2)->nullable(false);
            // enum("status", ["surplus","defisit","seimbang"])
            $table->enum('status', ['surplus', 'defisit', 'seimbang'])
                ->default('surplus')
                ->nullable(false);
            $table->timestamp('create_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Knex file: await knex.schema.dropTableIfExists(apbdes_tahun); <- error di knex, diperbaiki di sini
        Schema::dropIfExists('apbdes_tahun');
    }
};
