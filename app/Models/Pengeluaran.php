<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

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
