<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WajibPilihStatistik extends Model
{
    use HasFactory;

    protected $table = 'wajib_pilih_statistik';
    protected $primaryKey = 'id_wajib_pilih';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_id',
        'laki_laki',
        'perempuan',
        'total',
    ];

    protected $casts = [
        'laki_laki' => 'integer',
        'perempuan' => 'integer',
        'total' => 'integer',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
