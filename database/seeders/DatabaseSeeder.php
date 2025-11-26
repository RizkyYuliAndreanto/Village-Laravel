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
        // User::factory(10)->create();

        // Create admin user only if it doesn't exist
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Run all seeders in proper order
        $this->call([
            // Base data first
            TahunDataSeeder::class,

            // Demographic statistics
            DemografiPendudukSeeder::class,
            AgamaStatistikSeeder::class,
            PekerjaanStatistikSeeder::class,
            PendidikanStatistikSeeder::class,
            PerkawinanStatistikSeeder::class,
            UmurStatistikSeeder::class,
            WajibPilihStatistikSeeder::class,
            DusunStatistikSeeder::class,

            // Village structure
            StrukturOrganisasiSeeder::class,

            // APBDes related - COMMENTED OUT FOR NOW (features not implemented yet)
            BidangApbdesSeeder::class,
            LaporanApbdesSeeder::class,
            DetailApbdesSeeder::class,
            // ApbdesTahunSeeder::class,
            // PendapatanSeeder::class,
            // PengeluaranSeeder::class,

            // PPID Documents
            PpidDokumenSeeder::class,

            // UMKM and News
            KategoriUmkmSeeder::class,
            UmkmSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}
