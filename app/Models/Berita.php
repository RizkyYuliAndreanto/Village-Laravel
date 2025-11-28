<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\MediaStorageService;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'isi',
        'gambar_url',
        'kategori',
        'penulis',
    ];

    protected $casts = [
        'kategori' => 'string',
    ];

    // Mutator untuk gambar_url - convert array dari FileUpload ke string
    public function setGambarUrlAttribute($value)
    {
        if (is_array($value) && !empty($value)) {
            // Ambil file pertama dari array
            $this->attributes['gambar_url'] = $value[0];
        } elseif (is_string($value)) {
            $this->attributes['gambar_url'] = $value;
        } else {
            $this->attributes['gambar_url'] = null;
        }
    }

    // Kategori options
    public static function getKategoriOptions(): array
    {
        return [
            'umum' => 'Umum',
            'pengumuman' => 'Pengumuman',
            'kegiatan' => 'Kegiatan',
        ];
    }

    // Get full URL for gambar using simple asset path
    public function getImageUrlAttribute(): ?string
    {
        $gambar_url = $this->gambar_url;

        // Handle array data (corrupted)
        if (is_array($gambar_url)) {
            $gambar_url = !empty($gambar_url) ? $gambar_url[0] : null;
        }

        if (!$gambar_url) {
            return null;
        }

        // Jika sudah full URL, return as is
        if (filter_var($gambar_url, FILTER_VALIDATE_URL)) {
            return $gambar_url;
        }

        // Jika path relatif, gunakan asset storage
        return asset('storage/' . $gambar_url);
    }

    // Delete associated image file
    public function deleteImage(): bool
    {
        if (!$this->gambar_url) {
            return true;
        }

        $mediaService = app(MediaStorageService::class);
        return $mediaService->delete($this->gambar_url);
    }

    // Get MinIO image URL
    private function getMinioImageUrl(string $path): string
    {
        $minioUrl = config('filesystems.disks.minio.url');
        $bucket = config('filesystems.disks.minio.bucket');

        if ($minioUrl && $bucket) {
            return "{$minioUrl}/{$path}";
        }

        // Fallback to MinIO endpoint
        $endpoint = config('filesystems.disks.minio.endpoint');
        return "{$endpoint}/{$bucket}/{$path}";
    }

    // Check if using external storage (MinIO/S3)
    public function isUsingExternalStorage(): bool
    {
        $disk = config('filesystems.disks.media.driver', 'public');
        return in_array($disk, ['minio', 's3']);
    }
}
