<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgamaStatistik extends Model
{
    use HasFactory;

    protected $table = 'agama_statistik';
    protected $primaryKey = 'id_agama';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_id',
        'islam',
        'katolik',
        'kristen',
        'hindu',
        'buddha',
        'konghucu',
        'kepercayaan_lain',
    ];

    protected $casts = [
        'islam' => 'integer',
        'katolik' => 'integer',
        'kristen' => 'integer',
        'hindu' => 'integer',
        'buddha' => 'integer',
        'konghucu' => 'integer',
        'kepercayaan_lain' => 'integer',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
