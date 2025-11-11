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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id(); // increments("id").primary()

            // Relasi ke kategori_umkm
            $table->foreignId('kategori_id')
                ->unsigned()
                ->nullable(false)
                ->references('id')
                ->on('kategori_umkm')
                ->onDelete('restrict') // Disesuaikan dari Knex: RESTRICT
                ->onUpdate('cascade');

            $table->string('nama', 255)->nullable(false)->index();
            $table->string('slug', 255)->nullable(false)->unique();
            $table->text('deskripsi')->nullable();

            // Informasi Lokasi & Kontak
            $table->string('pemilik', 150)->nullable();
            $table->string('alamat', 500)->nullable();
            $table->string('dusun', 150)->nullable();
            $table->string('rt', 50)->nullable();
            $table->string('rw', 50)->nullable();
            $table->string('kecamatan', 150)->nullable();
            $table->string('kota', 150)->nullable();
            $table->string('provinsi', 150)->nullable();
            $table->string('kode_pos', 20)->nullable();

            $table->string('telepon', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('sosial_facebook', 255)->nullable();
            $table->string('sosial_instagram', 255)->nullable();
            $table->string('sosial_tiktok', 255)->nullable();
            $table->string('shopee_url', 255)->nullable();
            $table->string('tokopedia_url', 255)->nullable();
            $table->string('tiktokshop_url', 255)->nullable();

            // Data Usaha
            $table->string('jenis_usaha', 150)->nullable();
            $table->string('status_usaha', 50)->nullable()->comment('aktif / non-aktif');
            $table->decimal('omset_per_bulan', 14, 2)->nullable();
            $table->string('skala_usaha', 50)->nullable()->comment('mikro / kecil / menengah');
            $table->unsignedInteger('jumlah_karyawan')->nullable();

            // Media / Gambar
            $table->string('logo_url', 500)->nullable();
            $table->text('foto_galeri')->nullable()->comment('json array url jika ingin');

            // Timestamps
            $table->timestamps(); // creates created_at and updated_at

            // Index yang umum dipakai (kategori_id sudah terindeks oleh foreignId)
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
