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
        'status',
    ];

    protected $casts = [
        'kategori' => 'string',
    ];

    // Kategori options
    public static function getKategoriOptions(): array
    {
        return [
            'umum' => 'Umum',
            'pengumuman' => 'Pengumuman',
            'kegiatan' => 'Kegiatan',
        ];
    }

    // Get full URL for gambar using MediaStorageService
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->gambar_url) {
            return null;
        }

        $mediaService = app(MediaStorageService::class);
        return $mediaService->url($this->gambar_url);
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
