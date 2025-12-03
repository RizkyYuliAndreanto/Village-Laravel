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
        // Create admin user only if it doesn't exist
        if (!User::where('email', 'banyukambangasri@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'banyukambangasri@gmail.com',
                'password' => bcrypt('Amansejahtera123#'),
            ]);
        }

        // Seeder untuk data aplikasi
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

            // PPID Documents
            PpidDokumenSeeder::class,

            // UMKM and News
            KategoriUmkmSeeder::class,
            UmkmSeeder::class,
            BeritaSeeder::class,

            // APBDES data
            BidangApbdesSeeder::class,
            ContohApbdesSeeder::class,
            DetailApbdesSeeder::class,
            LaporanApbdesSeeder::class,
        ]);
    }
}
