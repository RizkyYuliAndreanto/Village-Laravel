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
        Schema::create('perkawinan_statistik', function (Blueprint $table) {
            $table->id('id_perkawinan'); // increments("id_perkawinan").primary()
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('kawin')->default(0)->nullable(false);
            $table->integer('cerai_hidup')->default(0)->nullable(false);
            $table->integer('cerai_mati')->default(0)->nullable(false);
            $table->integer('kawin_tercatat')->default(0)->nullable(false);
            $table->integer('kawin_tidak_tercatat')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkawinan_statistik');
    }
};
