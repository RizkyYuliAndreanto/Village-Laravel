<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ppid_dokumen', function (Blueprint $table) {
        $table->enum('status_publikasi', ['draft', 'published'])
              ->default('published')
              ->after('uploader');

        $table->date('tanggal_publikasi')
              ->nullable()
              ->after('status_publikasi');
    });
}

public function down()
{
    Schema::table('ppid_dokumen', function (Blueprint $table) {
        $table->dropColumn(['status_publikasi', 'tanggal_publikasi']);
    });
}

};
