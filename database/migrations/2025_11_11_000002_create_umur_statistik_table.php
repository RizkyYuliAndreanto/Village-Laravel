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
        Schema::create('umur_statistik', function (Blueprint $table) {
            $table->id('id_umur'); // increments("id_umur").primary()
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('umur_0_4')->default(0)->nullable(false);
            $table->integer('umur_5_9')->default(0)->nullable(false);
            $table->integer('umur_10_14')->default(0)->nullable(false);
            $table->integer('umur_15_19')->default(0)->nullable(false);
            $table->integer('umur_20_24')->default(0)->nullable(false);
            $table->integer('umur_25_29')->default(0)->nullable(false);
            $table->integer('umur_30_34')->default(0)->nullable(false);
            $table->integer('umur_35_39')->default(0)->nullable(false);
            $table->integer('umur_40_44')->default(0)->nullable(false);
            $table->integer('umur_45_49')->default(0)->nullable(false);
            $table->integer('umur_50_plus')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umur_statistik');
    }
};
