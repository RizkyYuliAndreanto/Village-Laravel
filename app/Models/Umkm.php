<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'kategori_id',
        'nama',
        'slug',
        'deskripsi',
        'pemilik',
        'alamat',
        'dusun',
        'rt',
        'rw',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'whatsapp',
        'email',
        'website',
        'sosial_facebook',
        'sosial_instagram',
        'sosial_tiktok',
        'shopee_url',
        'tokopedia_url',
        'tiktokshop_url',
        'jenis_usaha',
        'status_usaha',
        'omset_per_bulan',
        'skala_usaha',
        'jumlah_karyawan',
        'logo_url',
        'foto_galeri',
    ];

    protected $casts = [
        'nama' => 'string',
        'slug' => 'string',
        'deskripsi' => 'string',
        'pemilik' => 'string',
        'alamat' => 'string',
        'dusun' => 'string',
        'rt' => 'string',
        'rw' => 'string',
        'kecamatan' => 'string',
        'kota' => 'string',
        'provinsi' => 'string',
        'kode_pos' => 'string',
        'telepon' => 'string',
        'whatsapp' => 'string',
        'email' => 'string',
        'website' => 'string',
        'sosial_facebook' => 'string',
        'sosial_instagram' => 'string',
        'sosial_tiktok' => 'string',
        'shopee_url' => 'string',
        'tokopedia_url' => 'string',
        'tiktokshop_url' => 'string',
        'jenis_usaha' => 'string',
        'status_usaha' => 'string',
        'omset_per_bulan' => 'decimal:2',
        'skala_usaha' => 'string',
        'jumlah_karyawan' => 'integer',
        'logo_url' => 'string',
        'foto_galeri' => 'array', // JSON array
    ];

    // Status usaha constants
    const STATUS_AKTIF = 'aktif';
    const STATUS_NON_AKTIF = 'non-aktif';

    // Skala usaha constants
    const SKALA_MIKRO = 'mikro';
    const SKALA_KECIL = 'kecil';
    const SKALA_MENENGAH = 'menengah';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_AKTIF => 'Aktif',
            self::STATUS_NON_AKTIF => 'Non-Aktif',
        ];
    }

    public static function getSkalaOptions()
    {
        return [
            self::SKALA_MIKRO => 'Mikro',
            self::SKALA_KECIL => 'Kecil',
            self::SKALA_MENENGAH => 'Menengah',
        ];
    }

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama') && empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    // Relasi belongs to kategori_umkm (jika ada)
    public function kategori()
    {
        return $this->belongsTo(KategoriUmkm::class, 'kategori_id');
    }

    // Accessor untuk format omset
    public function getFormattedOmsetAttribute()
    {
        return 'Rp ' . number_format((float) $this->omset_per_bulan, 0, ',', '.');
    }

    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status_usaha', self::STATUS_AKTIF);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('pemilik', 'like', "%{$search}%")
                ->orWhere('jenis_usaha', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }
}
