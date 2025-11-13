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
        Schema::create('demografi_penduduk', function (Blueprint $table) {
            $table->id('id_demografi'); // increments("id_demografi").primary()
            $table->foreignId('tahun_id') // integer("tahun_id").unsigned().notNullable()
                ->constrained('tahun_data', 'id_tahun') // references("id_tahun").inTable("tahun_data")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('total_penduduk')->default(0)->nullable(false);
            $table->integer('laki_laki')->default(0)->nullable(false);
            $table->integer('perempuan')->default(0)->nullable(false);
            $table->integer('penduduk_sementara')->default(0)->nullable(false);
            $table->integer('mutasi_penduduk')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // timestamp("create_at").defaultTo(knex.fn.now())
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // timestamp("updated_at").defaultTo(knex.fn.now())
            // $table->timestamps(); // Bisa juga pakai ini, tapi saya pisahkan agar sesuai nama kolomnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demografi_penduduk');
    }
};
