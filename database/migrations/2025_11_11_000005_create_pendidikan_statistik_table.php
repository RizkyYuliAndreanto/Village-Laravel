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
        Schema::create('pendidikan_statistik', function (Blueprint $table) {
            $table->id('id_pendidikan'); // increments("id_pendidikan").primary()
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('tidak_sekolah')->default(0)->nullable(false);
            $table->integer('sd')->default(0)->nullable(false);
            $table->integer('smp')->default(0)->nullable(false);
            $table->integer('sma')->default(0)->nullable(false);
            $table->integer('d1_d4')->default(0)->nullable(false);
            $table->integer('s1')->default(0)->nullable(false);
            $table->integer('s2')->default(0)->nullable(false);
            $table->integer('s3')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan_statistik');
    }
};
