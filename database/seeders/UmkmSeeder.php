<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;
use App\Models\KategoriUmkm;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = KategoriUmkm::first();
        
        if($kategori) {
            Umkm::updateOrCreate(
                ['slug' => 'keripik-tempe-bu-ani'],
                [
                    'kategori_id' => $kategori->id,
                    'nama' => 'Keripik Tempe Bu Ani',
                    'deskripsi' => 'Keripik tempe renyah khas desa, dibuat dari kedelai pilihan.',
                    'pemilik' => 'Ibu Ani',
                    'alamat' => 'Jl. Mawar No. 10',
                    'dusun' => 'Dusun Krajan',
                    'telepon' => '081234567890',
                    'whatsapp' => '081234567890',
                    'status_usaha' => 'aktif',
                    'skala_usaha' => 'mikro',
                    'omset_per_bulan' => 5000000,
                ]
            );
        }
    }
}