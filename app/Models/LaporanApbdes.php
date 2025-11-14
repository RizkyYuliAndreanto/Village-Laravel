<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanApbdes extends Model
{
    use HasFactory;

    protected $table = 'laporan_apbdes';

    protected $fillable = [
        'tahun_id',
        'nama_laporan',
        'bulan_rilis',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'bulan_rilis' => 'integer',
        'status' => 'string',
    ];

    // Relasi ke Tahun
    public function tahunData(): BelongsTo
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }

    // Relasi ke Detail APBDes
    public function detailApbdes(): HasMany
    {
        return $this->hasMany(DetailApbdes::class, 'laporan_apbdes_id');
    }

    // Helper untuk nama bulan
    public function getNamaBulanAttribute()
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulan[$this->bulan_rilis] ?? '-';
    }

    // Helper untuk total anggaran
    public function getTotalAnggaranAttribute()
    {
        return $this->detailApbdes->sum('anggaran');
    }

    // Helper untuk total realisasi
    public function getTotalRealisasiAttribute()
    {
        return $this->detailApbdes->sum('realisasi');
    }
}
