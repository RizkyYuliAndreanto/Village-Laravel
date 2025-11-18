<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            // === MASTER DATA (HARUS DIJALANKAN DULU) ===
            // Data Tahun, dibutuhkan oleh semua seeder statistik
            TahunDataSeeder::class,
            // Data Kategori, dibutuhkan oleh UmkmSeeder
            KategoriUmkmSeeder::class,

            // === DATA KONTEN (INDEPENDEN) ===
            BeritaSeeder::class,
            StrukturOrganisasiSeeder::class,
            PpidDokumenSeeder::class,
            PendapatanSeeder::class,
            // GaleriSeeder::class, // Anda bisa tambahkan ini jika sudah dibuat

            // === DATA DEPENDEN (BERGANTUNG PADA MASTER) ===
            
            // Bergantung pada KategoriUmkmSeeder
            UmkmSeeder::class,

            // Bergantung pada TahunDataSeeder
            AgamaStatistikSeeder::class,
            DemografiPendudukSeeder::class,
            DusunStatistikSeeder::class,
            LaporanApbdesSeeder::class,
            PekerjaanStatistikSeeder::class,
            PendidikanStatistikSeeder::class,
            PerkawinanStatistikSeeder::class,
            UmurStatistikSeeder::class,
            WajibPilihStatistikSeeder::class,
        ]);
    }
}