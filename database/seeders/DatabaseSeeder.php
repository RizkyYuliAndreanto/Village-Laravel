<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ApbdesSeeder;
use Database\Seeders\StatistikDesaSeeder;
use Database\Seeders\UmurSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            StatistikDesaSeeder::class,
            ApbdesSeeder::class,
            UmurSeeder::class,
            PendidikanStatistikSeeder::class,
            PekerjaanStatistikSeeder::class,
            WajibPilihStatistikSeeder::class,
            PerkawinanStatistikSeeder::class,
        ]);
    }
}
