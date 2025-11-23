<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailApbdes extends Model
{
    use HasFactory;

    protected $table = 'detail_apbdes';

    protected $fillable = [
        'laporan_apbdes_id',
        'bidang_apbdes_id',
        'sub_bidang_apbdes_id',
        'tipe',
        'uraian',
        'anggaran',
        'realisasi',
        'persentase_realisasi',
        'keterangan',
        'bulan_realisasi',
    ];

    /**
     * Casting untuk memastikan nilai uang adalah float/decimal
     */
    protected $casts = [
        'anggaran' => 'decimal:2',
        'realisasi' => 'decimal:2',
        'persentase_realisasi' => 'decimal:2',
        'bulan_realisasi' => 'integer',
    ];

    /**
     * Relasi balik ke Laporan APBDes
     */
    public function laporanApbdes(): BelongsTo
    {
        return $this->belongsTo(LaporanApbdes::class);
    }

    /**
     * Relasi ke Bidang APBDes
     */
    public function bidangApbdes(): BelongsTo
    {
        return $this->belongsTo(BidangApbdes::class);
    }

    /**
     * Relasi ke Sub Bidang APBDes
     */
    public function subBidangApbdes(): BelongsTo
    {
        return $this->belongsTo(SubBidangApbdes::class);
    }

    /**
     * Mutator untuk auto-calculate persentase realisasi
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->anggaran > 0) {
                $model->persentase_realisasi = ($model->realisasi / $model->anggaran) * 100;
            }
        });
    }
}
