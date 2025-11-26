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
        'bidang_apbdes_id',     // Menambahkan ini
        'sub_bidang_apbdes_id', // Menambahkan ini
        'tipe',
        'uraian',
        'anggaran',
        'realisasi',
        'bulan_realisasi',      // Menambahkan ini
        'keterangan',           // Menambahkan ini
    ];

    /**
     * Casting untuk memastikan nilai uang adalah float/decimal
     */
    protected $casts = [
        'anggaran' => 'decimal:2',
        'realisasi' => 'decimal:2',
        'bidang_apbdes_id' => 'integer',
        'sub_bidang_apbdes_id' => 'integer',
        'bulan_realisasi' => 'integer',
    ];

    /**
     * Relasi ke Laporan APBDes
     */
    public function laporanApbdes(): BelongsTo
    {
        return $this->belongsTo(LaporanApbdes::class, 'laporan_apbdes_id');
    }

    /**
     * Relasi ke Bidang APBDes (WAJIB ADA agar ->relationship('bidangApbdes') bekerja)
     */
    public function bidangApbdes(): BelongsTo
    {
        return $this->belongsTo(BidangApbdes::class, 'bidang_apbdes_id');
    }

    /**
     * Relasi ke Sub Bidang APBDes (WAJIB ADA agar ->relationship('subBidangApbdes') bekerja)
     */
    public function subBidangApbdes(): BelongsTo
    {
        return $this->belongsTo(SubBidangApbdes::class, 'sub_bidang_apbdes_id');
    }
}