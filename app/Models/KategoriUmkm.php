<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriUmkm extends Model
{
    use HasFactory;

    protected $table = 'kategori_umkm';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'nama_kategori' => 'string',
        'deskripsi' => 'string',
        'icon' => 'string',
        'is_active' => 'boolean',
    ];

    // Relasi one-to-many dengan UMKM
    public function umkms()
    {
        return $this->hasMany(Umkm::class, 'kategori_id');
    }

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
