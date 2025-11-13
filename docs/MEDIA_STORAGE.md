# Media Storage Configuration

Aplikasi ini mendukung multiple storage drivers untuk media files (gambar, dokumen, dll):

## Storage Options

### 1. Local Storage (Default)

-   **Driver**: `public`
-   **Location**: `storage/app/public`
-   **Configuration**: Sudah aktif by default

### 2. MinIO Object Storage

-   **Driver**: `minio`
-   **Requirements**: MinIO Server
-   **Benefits**: Scalable, S3-compatible, self-hosted

### 3. AWS S3

-   **Driver**: `s3`
-   **Requirements**: AWS Account & S3 Bucket
-   **Benefits**: Cloud storage, global CDN

## Setup MinIO

### 1. Install MinIO Server

#### Using Docker:

```bash
# Pull MinIO image
docker pull minio/minio

# Create directories
mkdir -p ~/minio/data
mkdir -p ~/minio/config

# Run MinIO server
docker run -d \
  --name minio \
  -p 9000:9000 \
  -p 9001:9001 \
  -e MINIO_ROOT_USER=minioadmin \
  -e MINIO_ROOT_PASSWORD=minioadmin \
  -v ~/minio/data:/data \
  minio/minio server /data --console-address ":9001"
```

#### Using Binary:

```bash
# Download MinIO
wget https://dl.min.io/server/minio/release/windows-amd64/minio.exe

# Create data directory
mkdir C:\minio\data

# Run MinIO
minio.exe server C:\minio\data --console-address ":9001"
```

### 2. Configure Application

#### Update .env file:

```env
# Switch to MinIO storage
MEDIA_DISK_DRIVER=minio

# MinIO Configuration
MINIO_ACCESS_KEY=minioadmin
MINIO_SECRET_KEY=minioadmin
MINIO_REGION=us-east-1
MINIO_BUCKET=village-media
MINIO_ENDPOINT=http://localhost:9000
MINIO_URL=http://localhost:9000/village-media
MINIO_USE_PATH_STYLE_ENDPOINT=true
MINIO_CONSOLE_URL=http://localhost:9001
```

### 3. Create MinIO Bucket

1. Open MinIO Console: `http://localhost:9001`
2. Login dengan credentials: `minioadmin` / `minioadmin`
3. Create bucket dengan nama: `village-media`
4. Set bucket policy ke `public` (untuk public access)

### 4. Test Configuration

```bash
# Clear config cache
php artisan config:clear

# Test upload file melalui Filament admin
# atau test melalui tinker:
php artisan tinker
>>> $service = app(\App\Services\MediaStorageService::class);
>>> $service->getDisk();
>>> $service->getDriverName();
```

## Configuration Files

### Media Configuration (`config/media.php`)

-   Media storage settings
-   Upload constraints
-   Directory structure
-   Driver information

### Filesystem Configuration (`config/filesystems.php`)

-   Storage disk definitions
-   MinIO/S3 connections
-   Local storage settings

### Environment Variables

-   `.env` - Production/development settings
-   `.env.example` - Template dengan semua options

## Storage Service

### MediaStorageService Class

Located: `app/Services/MediaStorageService.php`

**Methods:**

-   `getDisk()` - Get current storage driver
-   `store($file, $directory)` - Store uploaded file
-   `url($path)` - Get public URL for file
-   `delete($path)` - Delete file
-   `exists($path)` - Check if file exists

**Usage:**

```php
$mediaService = app(\App\Services\MediaStorageService::class);

// Get driver info
$driverName = $mediaService->getDriverName();

// Store file
$path = $mediaService->store($uploadedFile, 'berita/images');

// Get URL
$url = $mediaService->url($path);

// Delete file
$mediaService->delete($path);
```

## Switching Storage Drivers

### From Local to MinIO:

1. Setup MinIO server
2. Create bucket
3. Update `.env`: `MEDIA_DISK_DRIVER=minio`
4. Clear config: `php artisan config:clear`

### From MinIO to S3:

1. Create S3 bucket
2. Get AWS credentials
3. Update `.env`: `MEDIA_DISK_DRIVER=s3`
4. Configure AWS settings in `.env`
5. Clear config: `php artisan config:clear`

### From Any to Local:

1. Update `.env`: `MEDIA_DISK_DRIVER=public`
2. Run: `php artisan storage:link`
3. Clear config: `php artisan config:clear`

## Troubleshooting

### MinIO Connection Issues:

-   Check if MinIO server is running: `http://localhost:9000`
-   Verify bucket exists and is accessible
-   Check network connectivity
-   Verify credentials in `.env`

### File Upload Issues:

-   Check disk permissions
-   Verify file size limits
-   Check allowed file extensions
-   Clear config cache: `php artisan config:clear`

### URL Generation Issues:

-   Verify `MINIO_URL` or `MINIO_ENDPOINT` in `.env`
-   Check bucket public policy
-   Test URL manually in browser

## Security Considerations

### MinIO:

-   Change default credentials in production
-   Use HTTPS in production
-   Configure proper bucket policies
-   Enable access logs

### S3:

-   Use IAM roles/policies
-   Enable versioning
-   Configure CORS if needed
-   Monitor costs and usage

### Local Storage:

-   Ensure proper file permissions
-   Regular backup strategy
-   Monitor disk space
-   Secure file access
