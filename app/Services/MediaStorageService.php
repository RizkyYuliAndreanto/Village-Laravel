<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Services\SharedHostingStorageService;

class MediaStorageService
{
    private string $defaultDisk;
    private SharedHostingStorageService $sharedHostingSync;

    public function __construct()
    {
        $this->defaultDisk = config('media.default_disk', 'public');
        $this->sharedHostingSync = new SharedHostingStorageService();
    }

    /**
     * Get the current media disk
     */
    public function getDisk(): string
    {
        return $this->defaultDisk;
    }

    /**
     * Get disk information
     */
    public function getDiskInfo(): array
    {
        $drivers = config('media.drivers', []);
        return $drivers[$this->defaultDisk] ?? [
            'name' => 'Unknown Storage',
            'description' => 'Storage driver not configured',
            'icon' => 'heroicon-o-question-mark-circle',
        ];
    }

    /**
     * Store uploaded file
     */
    public function store(UploadedFile $file, string $directory = 'uploads'): string
    {
        $disk = $this->getDiskForStorage();

        // Store file ke storage/app/public
        $path = $file->store($directory, $disk);

        // Sync ke public_html/storage untuk shared hosting
        $this->sharedHostingSync->syncFile($path);

        return $path;
    }

    /**
     * Get public URL for file
     */
    public function url(string $path): string
    {
        if (!$path) {
            return '';
        }

        return match ($this->defaultDisk) {
            'minio' => $this->getMinioUrl($path),
            's3' => $this->getS3Url($path),
            default => asset('storage/' . $path),
        };
    }

    /**
     * Delete file
     */
    public function delete(string $path): bool
    {
        $disk = $this->getDiskForStorage();
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Check if file exists
     */
    public function exists(string $path): bool
    {
        $disk = $this->getDiskForStorage();
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get file size
     */
    public function size(string $path): int
    {
        $disk = $this->getDiskForStorage();
        return Storage::disk($disk)->size($path);
    }

    /**
     * Get actual disk name for storage operations
     */
    public function getDiskForStorage(): string
    {
        return match ($this->defaultDisk) {
            'minio' => 'minio',
            's3' => 's3',
            default => 'public',
        };
    }

    /**
     * Get MinIO URL
     */
    private function getMinioUrl(string $path): string
    {
        $minioUrl = config('filesystems.disks.minio.url');
        $bucket = config('filesystems.disks.minio.bucket');
        $endpoint = config('filesystems.disks.minio.endpoint');

        if ($minioUrl) {
            return "{$minioUrl}/{$path}";
        }

        if ($endpoint && $bucket) {
            return "{$endpoint}/{$bucket}/{$path}";
        }

        // Fallback to asset
        return asset('storage/' . $path);
    }

    /**
     * Get S3 URL
     */
    private function getS3Url(string $path): string
    {
        $bucket = config('filesystems.disks.s3.bucket');
        $region = config('filesystems.disks.s3.region');
        $endpoint = config('filesystems.disks.s3.endpoint');

        if ($endpoint) {
            return "{$endpoint}/{$bucket}/{$path}";
        }

        return "https://{$bucket}.s3.{$region}.amazonaws.com/{$path}";
    }

    /**
     * Check if using external storage
     */
    public function isUsingExternalStorage(): bool
    {
        return in_array($this->defaultDisk, ['minio', 's3']);
    }

    /**
     * Get storage driver display name
     */
    public function getDriverName(): string
    {
        $info = $this->getDiskInfo();
        return $info['name'];
    }

    /**
     * Get configuration for Filament FileUpload component
     */
    public function getFilamentConfig(string $directory = 'uploads'): array
    {
        return [
            'disk' => $this->getDiskForStorage(),
            'directory' => config("media.directories.{$directory}", $directory),
            'visibility' => 'public',
            'maxSize' => config('media.uploads.max_size', 2048),
            'acceptedFileTypes' => array_map(
                fn($ext) => "image/{$ext}",
                config('media.uploads.allowed_extensions', ['jpeg', 'png', 'jpg', 'gif'])
            ),
        ];
    }
}
