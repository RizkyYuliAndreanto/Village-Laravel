<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PekerjaanStatistik;

class PekerjaanStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PekerjaanStatistik::create([
            'tahun_id'            => 1, // Sesuaikan dengan id_tahun yang ada
            'tidak_sekolah'       => 0, // Tidak dipakai, bisa dihapus jika tidak relevan
            'petani'              => 950,
            'pelajar_mahasiswa'   => 350,
            'pegawai_swasta'      => 5,
            'wiraswasta'          => 12,
            'ibu_rumah_tangga'    => 154,
            'belum_bekerja'       => 404,
            'lainnya'             => 3, // Buruh tani/perkebunan
        ]);
    }
}
