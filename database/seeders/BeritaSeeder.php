<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('berita')->truncate(); // reset data (opsional)

        $kategoris = ['umum', 'pengumuman', 'kegiatan'];
        $penulis = ['Admin Desa', 'Operator Desa', 'Kepala Desa', 'Sekretaris Desa'];

        for ($i = 1; $i <= 30; $i++) {
            Berita::create([
                'judul'       => 'Berita Desa ke-' . $i,
                'isi'         => fake()->paragraph(10, true),
                'gambar_url'  => null, // bisa diisi 'gambar/berita'.$i.'.jpg'
                'kategori'    => fake()->randomElement($kategoris),
                'penulis'     => fake()->randomElement($penulis),
                'created_at'  => fake()->dateTimeBetween('-2 years', 'now'),
                'updated_at'  => now(),
            ]);
        }
    }
}
