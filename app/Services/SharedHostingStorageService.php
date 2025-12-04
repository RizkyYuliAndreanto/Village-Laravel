<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Shared Hosting Storage Sync Service
 * Menangani sinkronisasi file antara storage/app/public dan public_html/storage
 */
class SharedHostingStorageService
{
    protected string $sourceRoot;
    protected string $publicRoot;
    protected bool $isSharedHosting;

    public function __construct()
    {
        $this->sourceRoot = storage_path('app/public');
        $this->publicRoot = public_path('storage');
        $this->isSharedHosting = env('SHARED_HOSTING_MODE', false);
    }

    /**
     * Sync file dari storage/app/public ke public_html/storage
     */
    public function syncFile(string $relativePath): bool
    {
        if (!$this->isSharedHosting) {
            return true; // Skip jika bukan shared hosting
        }

        try {
            $sourcePath = $this->sourceRoot . '/' . $relativePath;
            $publicPath = $this->publicRoot . '/' . $relativePath;

            // Pastikan source file exists
            if (!File::exists($sourcePath)) {
                Log::warning('Source file not found for sync', ['path' => $sourcePath]);
                return false;
            }

            // Buat directory jika belum ada
            $publicDir = dirname($publicPath);
            if (!File::exists($publicDir)) {
                File::makeDirectory($publicDir, 0755, true);
            }

            // Copy file
            return File::copy($sourcePath, $publicPath);
        } catch (\Exception $e) {
            Log::error('Failed to sync file to shared hosting storage', [
                'path' => $relativePath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Sync seluruh folder
     */
    public function syncDirectory(string $directory = ''): bool
    {
        if (!$this->isSharedHosting) {
            return true;
        }

        try {
            $sourceDir = $this->sourceRoot . ($directory ? '/' . $directory : '');
            $publicDir = $this->publicRoot . ($directory ? '/' . $directory : '');

            if (!File::exists($sourceDir)) {
                return false;
            }

            // Buat directory jika belum ada
            if (!File::exists($publicDir)) {
                File::makeDirectory($publicDir, 0755, true);
            }

            // Copy semua files
            $files = File::allFiles($sourceDir);
            foreach ($files as $file) {
                $relativePath = str_replace($sourceDir . '/', '', $file->getPathname());
                $this->syncFile(($directory ? $directory . '/' : '') . $relativePath);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to sync directory to shared hosting storage', [
                'directory' => $directory,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Setup initial sync - jalankan sekali saat deploy
     */
    public function initialSync(): bool
    {
        if (!$this->isSharedHosting) {
            return true;
        }

        try {
            // Buat folder structure yang diperlukan
            $directories = [
                'umkm/logos',
                'umkm/galeri',
                'berita',
                'galeri',
                'ppid-dokumen',
                'struktur-organisasi'
            ];

            foreach ($directories as $dir) {
                $publicDir = $this->publicRoot . '/' . $dir;
                if (!File::exists($publicDir)) {
                    File::makeDirectory($publicDir, 0755, true);
                }
            }

            // Sync semua file yang sudah ada
            return $this->syncDirectory();
        } catch (\Exception $e) {
            Log::error('Failed to perform initial sync', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Delete file dari public storage
     */
    public function deleteFile(string $relativePath): bool
    {
        if (!$this->isSharedHosting) {
            return true;
        }

        try {
            $publicPath = $this->publicRoot . '/' . $relativePath;

            if (File::exists($publicPath)) {
                return File::delete($publicPath);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete file from shared hosting storage', [
                'path' => $relativePath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check apakah storage sync berfungsi
     */
    public function checkSync(): array
    {
        $status = [
            'shared_hosting_mode' => $this->isSharedHosting,
            'source_exists' => File::exists($this->sourceRoot),
            'public_exists' => File::exists($this->publicRoot),
            'public_writable' => File::exists($this->publicRoot) && is_writable($this->publicRoot),
            'symlink_exists' => is_link($this->publicRoot),
        ];

        return $status;
    }
}
