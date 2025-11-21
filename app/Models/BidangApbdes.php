<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BidangApbdes extends Model
{
    use HasFactory;

    protected $table = 'bidang_apbdes';

    protected $fillable = [
        'kode_bidang',
        'nama_bidang',
        'kategori',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke Sub Bidang APBDes
     */
    public function subBidangApbdes(): HasMany
    {
        return $this->hasMany(SubBidangApbdes::class);
    }

    /**
     * Relasi ke Detail APBDes
     */
    public function detailApbdes(): HasMany
    {
        return $this->hasMany(DetailApbdes::class);
    }

    /**
     * Scope untuk bidang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk kategori pendapatan
     */
    public function scopePendapatan($query)
    {
        return $query->where('kategori', 'pendapatan');
    }

    /**
     * Scope untuk kategori belanja
     */
    public function scopeBelanja($query)
    {
        return $query->where('kategori', 'belanja');
    }

    /**
     * Helper untuk mendapatkan total anggaran per bidang
     */
    public function getTotalAnggaranAttribute()
    {
        return $this->detailApbdes()->sum('anggaran');
    }

    /**
     * Helper untuk mendapatkan total realisasi per bidang
     */
    public function getTotalRealisasiAttribute()
    {
        return $this->detailApbdes()->sum('realisasi');
    }
}
