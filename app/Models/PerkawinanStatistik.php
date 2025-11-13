<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkawinanStatistik extends Model
{
    use HasFactory;

    protected $table = 'perkawinan_statistik';
    protected $primaryKey = 'id_perkawinan';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_id',
        'kawin',
        'cerai_hidup',
        'cerai_mati',
        'kawin_tercatat',
        'kawin_tidak_tercatat',
    ];

    protected $casts = [
        'kawin' => 'integer',
        'cerai_hidup' => 'integer',
        'cerai_mati' => 'integer',
        'kawin_tercatat' => 'integer',
        'kawin_tidak_tercatat' => 'integer',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
