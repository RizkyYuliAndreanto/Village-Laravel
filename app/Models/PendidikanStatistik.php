<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanStatistik extends Model
{
    use HasFactory;

    protected $table = 'pendidikan_statistik';
    protected $primaryKey = 'id_pendidikan';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_id',
        'tidak_sekolah',
        'sd',
        'smp',
        'sma',
        'd1_d4',
        's1',
        's2',
        's3',
    ];

    protected $casts = [
        'tidak_sekolah' => 'integer',
        'sd' => 'integer',
        'smp' => 'integer',
        'sma' => 'integer',
        'd1_d4' => 'integer',
        's1' => 'integer',
        's2' => 'integer',
        's3' => 'integer',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
