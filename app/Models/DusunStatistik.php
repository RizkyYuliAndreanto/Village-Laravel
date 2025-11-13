<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DusunStatistik extends Model
{
    use HasFactory;

    protected $table = 'dusun_statistik';
    protected $primaryKey = 'id_dusun';

    protected $fillable = [
        'tahun_id',
        'nama_dusun',
        'jumlah_penduduk',
        'jumlah_kk',
        'keterangan',
    ];

    protected $casts = [
        'tahun_id' => 'integer',
        'jumlah_penduduk' => 'integer',
        'jumlah_kk' => 'integer',
    ];

    // Timestamps dengan nama custom
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    // Relasi ke TahunData
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
