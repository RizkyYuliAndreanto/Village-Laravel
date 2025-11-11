<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'pendapatan';

    protected $fillable = [
        'tahun_id',
        'kategori',
        'nama_rincian',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'kategori' => 'string',
        'nama_rincian' => 'string',
        'jumlah' => 'decimal:2',
        'keterangan' => 'string',
    ];

    // Relasi belongs to tahun_data
    public function tahunData()
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}
