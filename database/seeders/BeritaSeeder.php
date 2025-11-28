<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        Berita::create([
            'judul' => 'Gotong Royong Bersih Desa',
            'isi' => 'Warga desa melakukan kerja bakti membersihkan lingkungan...',
            'kategori' => 'kegiatan',
            'penulis' => 'Admin',
            'created_at' => now(),
        ]);

        Berita::create([
            'judul' => 'Pengumuman Penyaluran BLT',
            'isi' => 'Diberitahukan kepada warga penerima manfaat bahwa BLT akan cair pada...',
            'kategori' => 'pengumuman',
            'penulis' => 'Sekdes',
            'created_at' => now(),
        ]);
    }
}