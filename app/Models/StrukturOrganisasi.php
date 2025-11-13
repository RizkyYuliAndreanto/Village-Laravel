<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id_struktur';

    // Custom timestamp columns
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'nama',
        'jabatan',
        'foto_url',
        'keterangan',
    ];

    protected $casts = [
        'nama' => 'string',
        'jabatan' => 'string',
        'foto_url' => 'string',
        'keterangan' => 'string',
    ];
}
