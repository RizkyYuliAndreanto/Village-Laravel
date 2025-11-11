<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanStatistik extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_statistik';
    protected $primaryKey = 'id_pekerjaan';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_id',
        'tidak_sekolah',
        'petani',
        'pelajar_mahasiswa',
        'pegawai_swasta',
        'wiraswasta',
        'ibu_rumah_tangga',
        'belum_bekerja',
        'lainnya',
    ];

    protected $casts = [
        'tidak_sekolah' => 'integer',
        'petani' => 'integer',
        'pelajar_mahasiswa' => 'integer',
        'pegawai_swasta' => 'integer',
        'wiraswasta' => 'integer',
        'ibu_rumah_tangga' => 'integer',
        'belum_bekerja' => 'integer',
        'lainnya' => 'integer',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
