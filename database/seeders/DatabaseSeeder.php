<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            //Adin Credentials
            AdminUserSeeder::class,

            // 1. Data Utama / Master Data
            TahunDataSeeder::class,         
            
            // 2. Data Statistik (Bergantung pada TahunData)
            DemografiPendudukSeeder::class,
            UmurStatistikSeeder::class,
            AgamaStatistikSeeder::class,
            PekerjaanStatistikSeeder::class,
            PendidikanStatistikSeeder::class,
            PerkawinanStatistikSeeder::class,
            WajibPilihStatistikSeeder::class,
            DusunStatistikSeeder::class,
            
            // 3. APBDes (Bergantung pada TahunData)
            BidangApbdesSeeder::class,
            LaporanApbdesSeeder::class,
            DetailApbdesSeeder::class,

            // 4. Data UMKM & Ekonomi
            KategoriUmkmSeeder::class,
            UmkmSeeder::class,

            // 5. Data Umum / Lainnya
            StrukturOrganisasiSeeder::class,
            PpidDokumenSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}