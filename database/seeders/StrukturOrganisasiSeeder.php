<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Budi Santoso', 'jabatan' => 'Kepala Desa', 'foto_url' => 'kades.jpg'],
            ['nama' => 'Siti Aminah', 'jabatan' => 'Sekretaris Desa', 'foto_url' => 'sekdes.jpg'],
            ['nama' => 'Ahmad Rizky', 'jabatan' => 'Kaur Keuangan', 'foto_url' => 'kaur.jpg'],
        ];

        foreach ($data as $item) {
            StrukturOrganisasi::updateOrCreate(['jabatan' => $item['jabatan']], $item);
        }
    }
}