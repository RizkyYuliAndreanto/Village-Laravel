<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'pendapatan';

    protected $fillable = [
        'tahun_id',
        'total_pendapatan',
        'keterangan',
    ];

    protected $casts = [
        'total_pendapatan' => 'decimal:2',
    ];

    /**
     * Relasi ke TahunData
     */
    public function tahunData(): BelongsTo
    {
        return $this->belongsTo(TahunData::class, 'tahun_id', 'id_tahun');
    }
}