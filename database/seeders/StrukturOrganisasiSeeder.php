<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strukturData = [
            [
                'nama' => 'Budi Santoso',
                'jabatan' => 'Kepala Desa',
                'foto_url' => 'struktur/kepala-desa.jpg',
                'keterangan' => 'Kepala Desa periode 2019-2025, berpengalaman dalam pembangunan infrastruktur desa',
            ],
            [
                'nama' => 'Siti Aminah',
                'jabatan' => 'Sekretaris Desa',
                'foto_url' => 'struktur/sekretaris-desa.jpg',
                'keterangan' => 'Sekretaris Desa, menangani administrasi dan tata kelola pemerintahan desa',
            ],
            [
                'nama' => 'Ahmad Wijaya',
                'jabatan' => 'Kaur Keuangan',
                'foto_url' => 'struktur/kaur-keuangan.jpg',
                'keterangan' => 'Kepala Urusan Keuangan, bertanggung jawab atas pengelolaan keuangan desa',
            ],
            [
                'nama' => 'Rina Handayani',
                'jabatan' => 'Kaur Umum',
                'foto_url' => 'struktur/kaur-umum.jpg',
                'keterangan' => 'Kepala Urusan Umum, menangani administrasi umum dan pelayanan masyarakat',
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'jabatan' => 'Kaur Pembangunan',
                'foto_url' => 'struktur/kaur-pembangunan.jpg',
                'keterangan' => 'Kepala Urusan Pembangunan, mengkoordinir program pembangunan desa',
            ],
            [
                'nama' => 'Yuni Astuti',
                'jabatan' => 'Kasi Kesejahteraan',
                'foto_url' => 'struktur/kasi-kesejahteraan.jpg',
                'keterangan' => 'Kepala Seksi Kesejahteraan, menangani program sosial kemasyarakatan',
            ],
            [
                'nama' => 'Rudi Hartono',
                'jabatan' => 'Kasi Pemerintahan',
                'foto_url' => 'struktur/kasi-pemerintahan.jpg',
                'keterangan' => 'Kepala Seksi Pemerintahan, mengurus administrasi kependudukan',
            ],
            [
                'nama' => 'Indah Permatasari',
                'jabatan' => 'Kasi Pelayanan',
                'foto_url' => 'struktur/kasi-pelayanan.jpg',
                'keterangan' => 'Kepala Seksi Pelayanan, melayani kebutuhan administrasi warga',
            ],
            [
                'nama' => 'Joko Susilo',
                'jabatan' => 'Kadus Mawar',
                'foto_url' => 'struktur/kadus-mawar.jpg',
                'keterangan' => 'Kepala Dusun Mawar, koordinator wilayah Dusun Mawar',
            ],
            [
                'nama' => 'Sri Rahayu',
                'jabatan' => 'Kadus Melati',
                'foto_url' => 'struktur/kadus-melati.jpg',
                'keterangan' => 'Kepala Dusun Melati, koordinator wilayah Dusun Melati',
            ],
        ];

        foreach ($strukturData as $data) {
            StrukturOrganisasi::create($data);
        }
    }
}
