<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            // Ubah logo_url menjadi logo_path untuk file upload
            $table->renameColumn('logo_url', 'logo_path');

            // Tambah kolom baru untuk foto galeri dengan path file
            $table->json('foto_galeri_paths')->nullable()->after('foto_galeri')
                ->comment('JSON array untuk menyimpan path file gambar galeri');

            // Backup data lama
            $table->text('foto_galeri_backup')->nullable()->after('foto_galeri_paths')
                ->comment('Backup data foto_galeri lama (URL)');
        });

        // Backup data lama ke kolom backup
        DB::table('umkms')->whereNotNull('foto_galeri')->update([
            'foto_galeri_backup' => DB::raw('foto_galeri')
        ]);

        Schema::table('umkms', function (Blueprint $table) {
            // Hapus kolom foto_galeri lama setelah backup
            $table->dropColumn('foto_galeri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            // Kembalikan kolom foto_galeri
            $table->text('foto_galeri')->nullable()->after('logo_path')
                ->comment('json array url jika ingin');
        });

        // Restore data dari backup
        DB::table('umkms')->whereNotNull('foto_galeri_backup')->update([
            'foto_galeri' => DB::raw('foto_galeri_backup')
        ]);

        Schema::table('umkms', function (Blueprint $table) {
            // Kembalikan nama kolom logo
            $table->renameColumn('logo_path', 'logo_url');

            // Hapus kolom baru
            $table->dropColumn(['foto_galeri_paths', 'foto_galeri_backup']);
        });
    }
};
