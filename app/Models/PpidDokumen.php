<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpidDokumen extends Model
{
    use HasFactory;

    protected $table = 'ppid_dokumen';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'judul_dokumen',
        'file_url',
        'kategori',
        'tahun',
        'tanggal_upload',
        'uploader',
    ];

    protected $casts = [
        'judul_dokumen' => 'string',
        'file_url' => 'string',
        'kategori' => 'string',
        'tahun' => 'integer',
        'tanggal_upload' => 'date',
        'uploader' => 'string',
    ];

    // Enum values untuk kategori
    const KATEGORI_BERKALA = 'informasi berkala';
    const KATEGORI_SERTAMERTA = 'informasi sertamerta';
    const KATEGORI_SETIAP_SAAT = 'informasi setiap saat';
    const KATEGORI_DIKECUALIKAN = 'informasi dikecualikan';

    public static function getKategoriOptions()
    {
        return [
            self::KATEGORI_BERKALA => 'Informasi Berkala',
            self::KATEGORI_SERTAMERTA => 'Informasi Sertamerta',
            self::KATEGORI_SETIAP_SAAT => 'Informasi Setiap Saat',
            self::KATEGORI_DIKECUALIKAN => 'Informasi Dikecualikan',
        ];
    }
}
