<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriUmkm;

class KategoriUmkmSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Kuliner', 'icon' => 'fas fa-utensils'],
            ['nama_kategori' => 'Kerajinan Tangan', 'icon' => 'fas fa-hands'],
            ['nama_kategori' => 'Pertanian', 'icon' => 'fas fa-leaf'],
            ['nama_kategori' => 'Jasa', 'icon' => 'fas fa-concierge-bell'],
            ['nama_kategori' => 'Fashion', 'icon' => 'fas fa-tshirt'],
        ];

        foreach ($kategori as $cat) {
            KategoriUmkm::updateOrCreate(['nama_kategori' => $cat['nama_kategori']], $cat);
        }
    }
}