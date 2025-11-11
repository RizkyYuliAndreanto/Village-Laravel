<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'judul',
        'isi',
        'gambar_url',
        'kegiatan',
        'penulis',
    ];

    protected $casts = [
        'judul' => 'string',
        'isi' => 'string',
        'gambar_url' => 'string',
        'kegiatan' => 'string',
        'penulis' => 'string',
    ];

    // Enum values untuk kegiatan
    const KEGIATAN_UMUM = 'umum';
    const KEGIATAN_PENGUMUMAN = 'pengumuman';
    const KEGIATAN_KEGIATAN = 'kegiatan';

    public static function getKegiatanOptions()
    {
        return [
            self::KEGIATAN_UMUM => 'Umum',
            self::KEGIATAN_PENGUMUMAN => 'Pengumuman',
            self::KEGIATAN_KEGIATAN => 'Kegiatan',
        ];
    }
}
