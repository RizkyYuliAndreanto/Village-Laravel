<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmurStatistik extends Model
{
    use HasFactory;

    protected $table = 'umur_statistik';
    protected $primaryKey = 'id_umur';

    protected $fillable = [
        'tahun_id',
        'umur_0_4',
        'umur_5_9',
        'umur_10_14',
        'umur_15_19',
        'umur_20_24',
        'umur_25_29',
        'umur_30_34',
        'umur_35_39',
        'umur_40_44',
        'umur_45_49',
        'umur_50_plus',
    ];

    protected $casts = [
        'umur_0_4' => 'integer',
        'umur_5_9' => 'integer',
        'umur_10_14' => 'integer',
        'umur_15_19' => 'integer',
        'umur_20_24' => 'integer',
        'umur_25_29' => 'integer',
        'umur_30_34' => 'integer',
        'umur_35_39' => 'integer',
        'umur_40_44' => 'integer',
        'umur_45_49' => 'integer',
        'umur_50_plus' => 'integer',
    ];

    // Custom timestamps
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
