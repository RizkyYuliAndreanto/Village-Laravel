<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\KategoriUmkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Kategori Ada (Safety Check)
        $kategoris = [
            'Kuliner', 'Perdagangan', 'Jasa', 'Pertanian', 'Fashion', 'Kerajinan', 'Teknologi'
        ];

        foreach ($kategoris as $kat) {
            KategoriUmkm::firstOrCreate(
                ['slug' => Str::slug($kat)],
                ['nama_kategori' => $kat]
            );
        }

        // 2. Data UMKM Dummy
        $umkmData = [
            // KULINER
            [
                'kategori' => 'Kuliner',
                'nama' => 'Warung Makan Pak Budi',
                'pemilik' => 'Budi Santoso',
                'deskripsi' => 'Warung makan tradisional dengan menu khas daerah, soto dan rawon.',
                'alamat' => 'Jl. Raya Desa No. 123',
                'dusun' => 'Dusun Krajan',
                'jenis_usaha' => 'kuliner',
                'omset_per_bulan' => 15000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2020,
            ],
            [
                'kategori' => 'Kuliner',
                'nama' => 'Catering Bu Ani',
                'pemilik' => 'Ani Wijaya',
                'deskripsi' => 'Jasa catering untuk acara pernikahan, khitanan, dan rapat.',
                'alamat' => 'Jl. Melati No. 12',
                'dusun' => 'Dusun Melati',
                'jenis_usaha' => 'kuliner',
                'omset_per_bulan' => 25000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2021,
            ],
            [
                'kategori' => 'Kuliner',
                'nama' => 'Keripik Singkong Maknyus',
                'pemilik' => 'Suharti',
                'deskripsi' => 'Produksi keripik singkong aneka rasa, oleh-oleh khas desa.',
                'alamat' => 'Jl. Mawar No. 05',
                'dusun' => 'Dusun Mawar',
                'jenis_usaha' => 'kuliner',
                'omset_per_bulan' => 8000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2022,
            ],

            // PERDAGANGAN
            [
                'kategori' => 'Perdagangan',
                'nama' => 'Toko Kelontong Ibu Siti',
                'pemilik' => 'Siti Aminah',
                'deskripsi' => 'Menyediakan sembako dan kebutuhan rumah tangga lengkap.',
                'alamat' => 'Jl. Mawar No. 45',
                'dusun' => 'Dusun Mawar',
                'jenis_usaha' => 'perdagangan',
                'omset_per_bulan' => 12000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2020,
            ],
            [
                'kategori' => 'Perdagangan',
                'nama' => 'Toko Bangunan Maju Jaya',
                'pemilik' => 'Rahman Hakim',
                'deskripsi' => 'Menjual material bangunan, semen, pasir, dan alat pertukangan.',
                'alamat' => 'Jl. Konstruksi No. 88',
                'dusun' => 'Dusun Krajan',
                'jenis_usaha' => 'perdagangan',
                'omset_per_bulan' => 45000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2021,
            ],

            // JASA
            [
                'kategori' => 'Jasa',
                'nama' => 'Bengkel Motor Barokah',
                'pemilik' => 'Joko Widodo',
                'deskripsi' => 'Service motor, ganti oli, dan tambal ban.',
                'alamat' => 'Jl. Kendaraan No. 78',
                'dusun' => 'Dusun Krajan',
                'jenis_usaha' => 'jasa',
                'omset_per_bulan' => 9000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2020,
            ],
            [
                'kategori' => 'Jasa',
                'nama' => 'Loundry Bersih Wangi',
                'pemilik' => 'Rina Sari',
                'deskripsi' => 'Jasa cuci dan setrika pakaian, kilat dan rapi.',
                'alamat' => 'Jl. Anggrek No. 22',
                'dusun' => 'Dusun Melati',
                'jenis_usaha' => 'jasa',
                'omset_per_bulan' => 5000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2023,
            ],

            // PERTANIAN
            [
                'kategori' => 'Pertanian',
                'nama' => 'Tani Organik Sejahtera',
                'pemilik' => 'Tono Sukarno',
                'deskripsi' => 'Budidaya sayuran organik dan penyediaan bibit unggul.',
                'alamat' => 'Jl. Sawah Raya No. 99',
                'dusun' => 'Dusun Mawar',
                'jenis_usaha' => 'pertanian',
                'omset_per_bulan' => 18000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2021,
            ],

            // FASHION
            [
                'kategori' => 'Fashion',
                'nama' => 'Butik Hijab Modern',
                'pemilik' => 'Fatimah Zahra',
                'deskripsi' => 'Menjual gamis, hijab, dan busana muslim kekinian.',
                'alamat' => 'Jl. Fashion No. 33',
                'dusun' => 'Dusun Melati',
                'jenis_usaha' => 'fashion',
                'omset_per_bulan' => 15000000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2022,
            ],
            
            // CRAFT
            [
                'kategori' => 'Kerajinan',
                'nama' => 'Kerajinan Bambu Lestari',
                'pemilik' => 'Pak Bambang',
                'deskripsi' => 'Kerajinan tangan dari bambu: kursi, meja, dan hiasan lampu.',
                'alamat' => 'Jl. Bambu Runcing',
                'dusun' => 'Dusun Krajan',
                'jenis_usaha' => 'kerajinan',
                'omset_per_bulan' => 7500000,
                'status_usaha' => 'aktif',
                'tahun_berdiri' => 2024, // UMKM Baru
            ],
        ];

        foreach ($umkmData as $data) {
            // Cari ID Kategori
            $kategori = KategoriUmkm::where('nama_kategori', $data['kategori'])->first();
            
            // Set Tanggal Created At sesuai tahun berdiri
            $createdAt = Carbon::create($data['tahun_berdiri'], rand(1, 12), rand(1, 28));

            Umkm::updateOrCreate(
                ['slug' => Str::slug($data['nama'])], // Key unik
                [
                    'kategori_id' => $kategori->id,
                    'nama' => $data['nama'],
                    'deskripsi' => $data['deskripsi'],
                    'pemilik' => $data['pemilik'],
                    'alamat' => $data['alamat'],
                    'dusun' => $data['dusun'],
                    'rt' => sprintf('%03d', rand(1, 5)),
                    'rw' => sprintf('%03d', rand(1, 3)),
                    'kecamatan' => 'Kecamatan Contoh',
                    'kota' => 'Kabupaten Contoh',
                    'provinsi' => 'Jawa Timur',
                    'kode_pos' => '6321' . rand(0, 9),
                    'telepon' => '0812' . rand(10000000, 99999999),
                    'whatsapp' => '0812' . rand(10000000, 99999999),
                    'email' => Str::slug($data['nama']) . '@gmail.com',
                    'jenis_usaha' => $data['jenis_usaha'],
                    'status_usaha' => $data['status_usaha'],
                    'omset_per_bulan' => $data['omset_per_bulan'],
                    'skala_usaha' => $data['omset_per_bulan'] > 20000000 ? 'kecil' : 'mikro',
                    'jumlah_karyawan' => rand(1, 5),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]
            );
        }
    }
}