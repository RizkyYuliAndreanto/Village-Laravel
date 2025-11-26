<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    // Sesuaikan fillable dengan migrasi create_berita_table_new
    protected $fillable = [
        'judul',
        'isi',
        'gambar_url',
        'kategori',
        'penulis',
        // 'status' kita hapus karena tidak ada di tabel
    ];

    // Accessor: Agar view yang memanggil $item->gambar tetap jalan
    // Mengambil nilai dari kolom gambar_url
    public function getGambarAttribute()
    {
        return $this->gambar_url;
    }

    // Accessor: Agar view yang memanggil $item->image tetap jalan
    public function getImageAttribute()
    {
        return $this->gambar_url;
    }
}