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
        Schema::create('wajib_pilih_statistik', function (Blueprint $table) {
            $table->id('id_wajib_pilih'); // increments("id_wajib_pilih").primary()
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('laki_laki')->default(0)->nullable(false);
            $table->integer('perempuan')->default(0)->nullable(false);
            $table->integer('total')->default(0)->nullable(false);
            $table->timestamp('create_at')->useCurrent(); // create_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perhatikan bahwa Knex dropTableIfExists di file aslinya salah ketik ("wajib_piih_statistik")
        Schema::dropIfExists('wajib_pilih_statistik');
    }
};
