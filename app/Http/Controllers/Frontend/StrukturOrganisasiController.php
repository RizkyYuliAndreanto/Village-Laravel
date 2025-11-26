<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id_struktur';

    // Sesuaikan nama timestamp jika di migrasi menggunakan nama custom
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'nama',
        'jabatan',
        'foto_url',
        'keterangan',
    ];

    // ACCESSOR: Agar view yang memanggil $pamong->foto tetap jalan
    public function getFotoAttribute()
    {
        return $this->foto_url;
    }

    // ACCESSOR: Agar view yang memanggil $pamong->image tetap jalan
    public function getImageAttribute()
    {
        return $this->foto_url;
    }
}