<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        
        // Hapus berita lama biar bersih saat re-seed (opsional)
        // Berita::truncate(); 

        $categories = ['umum', 'kegiatan', 'pengumuman'];
        $years = range(2020, 2025);

        foreach ($years as $year) {
            // Buat 3-5 berita per tahun
            $jumlahBerita = rand(3, 5);
            
            for ($i = 1; $i <= $jumlahBerita; $i++) {
                $bulan = rand(1, 12);
                $hari = rand(1, 28);
                $date = Carbon::create($year, $bulan, $hari, 10, 0, 0);
                
                $judul = "Kegiatan Desa Edisi $i Tahun $year";
                if ($year == 2025) {
                    $judul = "Update Pembangunan Desa Bulan $bulan 2025";
                }

                Berita::create([
                    'judul' => $judul,
                    // Slug otomatis dibuat oleh Model/Observer biasanya, 
                    // tapi kalau manual: \Str::slug($judul)
                    'slug' => \Illuminate\Support\Str::slug($judul), 
                    'excerpt' => "Ringkasan kegiatan desa yang terlaksana pada bulan $bulan tahun $year dengan lancar.",
                    'isi' => "<p>Ini adalah detail berita kegiatan yang dilaksanakan pada tanggal {$date->translatedFormat('d F Y')}. Kegiatan berjalan dengan lancar dan dihadiri warga.</p>",
                    'kategori' => $categories[array_rand($categories)],
                    'penulis_id' => $user->id,
                    'status' => 'published',
                    'published_at' => $date,
                    'created_at' => $date,
                    'updated_at' => $date,
                    'is_featured' => ($year == 2025 && $i == 1) ? true : false,
                ]);
            }
        }
    }
}