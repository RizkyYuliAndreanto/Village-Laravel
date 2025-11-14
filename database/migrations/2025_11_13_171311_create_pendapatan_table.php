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
        Schema::create('pendapatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_id')
                ->constrained('tahun_data', 'id_tahun')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Unique constraint
            $table->unique('tahun_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatan');
    }
};
