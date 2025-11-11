<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemografiPenduduk extends Model
{
    use HasFactory;

    protected $table = 'demografi_penduduk';
    protected $primaryKey = 'id_demografi';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_id',
        'total_penduduk',
        'laki_laki',
        'perempuan',
        'penduduk_sementara',
        'mutasi_penduduk',
    ];

    protected $casts = [
        'total_penduduk' => 'integer',
        'laki_laki' => 'integer',
        'perempuan' => 'integer',
        'penduduk_sementara' => 'integer',
        'mutasi_penduduk' => 'integer',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
