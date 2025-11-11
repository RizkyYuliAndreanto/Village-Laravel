<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunData extends Model
{
    use HasFactory;

    protected $table = 'tahun_data';
    protected $primaryKey = 'id_tahun';

    protected $fillable = [
        'tahun',
        'keterangan',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    // Relasi one-to-many dengan tabel lain
    public function demografiPenduduk()
    {
        return $this->hasMany(DemografiPenduduk::class, 'tahun_id', 'id_tahun');
    }

    public function umurStatistik()
    {
        return $this->hasMany(UmurStatistik::class, 'tahun_id', 'id_tahun');
    }

    public function agamaStatistik()
    {
        return $this->hasMany(AgamaStatistik::class, 'tahun_id', 'id_tahun');
    }

    public function pekerjaanStatistik()
    {
        return $this->hasMany(PekerjaanStatistik::class, 'tahun_id', 'id_tahun');
    }

    public function pendidikanStatistik()
    {
        return $this->hasMany(PendidikanStatistik::class, 'tahun_id', 'id_tahun');
    }

    public function perkawinanStatistik()
    {
        return $this->hasMany(PerkawinanStatistik::class, 'tahun_id', 'id_tahun');
    }

    public function wajibPilihStatistik()
    {
        return $this->hasMany(WajibPilihStatistik::class, 'tahun_id', 'id_tahun');
    }

    public function pendapatan()
    {
        return $this->hasMany(Pendapatan::class, 'tahun_id', 'id_tahun');
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'tahun_id', 'id_tahun');
    }
}
