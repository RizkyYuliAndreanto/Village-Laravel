<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubBidangApbdes extends Model
{
    use HasFactory;

    protected $table = 'sub_bidang_apbdes';

    protected $fillable = [
        'bidang_apbdes_id',
        'kode_sub_bidang',
        'nama_sub_bidang',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke Bidang APBDes
     */
    public function bidangApbdes(): BelongsTo
    {
        return $this->belongsTo(BidangApbdes::class);
    }

    /**
     * Relasi ke Detail APBDes
     */
    public function detailApbdes(): HasMany
    {
        return $this->hasMany(DetailApbdes::class);
    }

    /**
     * Scope untuk sub bidang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
