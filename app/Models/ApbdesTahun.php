<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApbdesTahun extends Model
{
    use HasFactory;

    protected $table = 'apbdes_tahun';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun',
        'total_pendapatan',
        'total_pengeluaran',
        'saldo_akhir',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'total_pendapatan' => 'decimal:2',
        'total_pengeluaran' => 'decimal:2',
        'saldo_akhir' => 'decimal:2',
        'status' => 'string',
    ];

    // Enum values untuk status
    const STATUS_SURPLUS = 'surplus';
    const STATUS_DEFISIT = 'defisit';
    const STATUS_SEIMBANG = 'seimbang';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_SURPLUS => 'Surplus',
            self::STATUS_DEFISIT => 'Defisit',
            self::STATUS_SEIMBANG => 'Seimbang',
        ];
    }
}
