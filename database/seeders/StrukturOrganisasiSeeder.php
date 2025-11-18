<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StrukturOrganisasi::query()->delete();

        StrukturOrganisasi::create([
            'nama' => 'Ahmad Subagja',
            'jabatan' => 'Kepala Desa',
            'foto_url' => 'images/sotk/kades.jpg',
            'keterangan' => 'Penanggung jawab pemerintahan desa.',
        ]);

        StrukturOrganisasi::create([
            'nama' => 'Siti Aminah',
            'jabatan' => 'Sekretaris Desa',
            'foto_url' => 'images/sotk/sekdes.jpg',
            'keterangan' => 'Administrasi dan kesekretariatan.',
        ]);

        StrukturOrganisasi::create([
            'nama' => 'Bambang Irawan',
            'jabatan' => 'Kaur Keuangan',
            'foto_url' => 'images/sotk/kaur_keuangan.jpg',
            'keterangan' => 'Pengelola keuangan dan aset desa.',
        ]);
        
        StrukturOrganisasi::create([
            'nama' => 'Dewi Lestari',
            'jabatan' => 'Kaur Perencanaan',
            'foto_url' => 'images/sotk/kaur_perencanaan.jpg',
            'keterangan' => 'Perencanaan pembangunan desa.',
        ]);
    }
}