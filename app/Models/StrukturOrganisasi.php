<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\MediaStorageService;

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

    /**
     * Mutator for foto_url - converts array from FileUpload to string
     */
    public function setFotoUrlAttribute($value)
    {
        if (is_array($value) && !empty($value) && isset($value[0])) {
            // Handle array from FileUpload component - take first file
            $this->attributes['foto_url'] = $value[0];
        } elseif (is_string($value)) {
            // Handle string path - keep as is
            $this->attributes['foto_url'] = $value;
        } else {
            // Handle null or empty
            $this->attributes['foto_url'] = null;
        }
    }

    /**
     * Accessor for foto_url - returns string for display
     */
    public function getFotoUrlAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // If it's already a full URL, return as is
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // If it's a relative path, convert to storage URL
        if (str_starts_with($value, 'struktur-organisasi/')) {
            return asset('storage/' . $value);
        }

        return $value;
    }
}
