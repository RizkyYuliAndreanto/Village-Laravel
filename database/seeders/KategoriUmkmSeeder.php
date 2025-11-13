<?php

namespace Database\Seeders;

use App\Models\KategoriUmkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriUmkmSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Kuliner',
                'deskripsi' => 'Usaha di bidang makanan dan minuman',
                'icon' => '🍽️',
                'is_active' => true
            ],
            [
                'nama_kategori' => 'Perdagangan',
                'deskripsi' => 'Usaha jual beli barang dan komoditas',
                'icon' => '🛒',
                'is_active' => true
            ],
            [
                'nama_kategori' => 'Jasa',
                'deskripsi' => 'Usaha penyedia layanan jasa',
                'icon' => '🔧',
                'is_active' => true
            ],
            [
                'nama_kategori' => 'Pertanian',
                'deskripsi' => 'Usaha di bidang pertanian dan perkebunan',
                'icon' => '🌾',
                'is_active' => true
            ],
            [
                'nama_kategori' => 'Fashion',
                'deskripsi' => 'Usaha di bidang pakaian dan aksesoris',
                'icon' => '👗',
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            KategoriUmkm::create($category);
        }
    }
}
