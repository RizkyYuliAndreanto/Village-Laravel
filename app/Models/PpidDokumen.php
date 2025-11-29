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

    // Mutator untuk file_url
    public function setFileUrlAttribute($value)
    {
        if (is_array($value) && !empty($value)) {
            // Jika value adalah array (dari file upload), ambil file pertama
            $filename = $value[0];
            $this->attributes['file_url'] = 'ppid-dokumen/' . $filename;
        } elseif (is_string($value) && !empty($value)) {
            // Jika sudah string, gunakan langsung
            $this->attributes['file_url'] = $value;
        } else {
            $this->attributes['file_url'] = null;
        }
    }

    // Accessor untuk mendapatkan full URL
    public function getFileUrlAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika sudah full URL, return langsung
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Jika path relatif, buat full URL
        return asset('storage/' . $value);
    }

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
