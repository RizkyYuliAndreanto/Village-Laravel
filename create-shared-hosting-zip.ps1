# Script untuk menyiapkan file ZIP untuk shared hosting
# Jalankan dengan: .\create-shared-hosting-zip.ps1

Write-Host "🚀 Mempersiapkan file untuk shared hosting..." -ForegroundColor Green

# Pastikan build assets sudah dibuat
Write-Host "📦 Building assets..." -ForegroundColor Yellow
npm run build

# Cache untuk production
Write-Host "⚡ Creating production cache..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Buat folder temporary
$tempFolder = "shared-hosting-upload"
if (Test-Path $tempFolder) {
    Remove-Item -Path $tempFolder -Recurse -Force
}
New-Item -ItemType Directory -Path $tempFolder | Out-Null

# Copy files dan folders yang diperlukan
Write-Host "📁 Copying required files..." -ForegroundColor Yellow

$foldersToInclude = @(
    "app",
    "bootstrap", 
    "config",
    "database",
    "public",
    "resources", 
    "routes",
    "storage",
    "vendor"
)

$filesToInclude = @(
    "artisan",
    "composer.json",
    "composer.lock"
)

# Copy folders
foreach ($folder in $foldersToInclude) {
    if (Test-Path $folder) {
        Write-Host "  ✓ Copying $folder/" -ForegroundColor Cyan
        Copy-Item -Path $folder -Destination "$tempFolder\$folder" -Recurse
    }
}

# Copy files
foreach ($file in $filesToInclude) {
    if (Test-Path $file) {
        Write-Host "  ✓ Copying $file" -ForegroundColor Cyan
        Copy-Item -Path $file -Destination "$tempFolder\$file"
    }
}

# Copy .env untuk shared hosting
if (Test-Path ".env.shared-hosting") {
    Write-Host "  ✓ Copying .env.shared-hosting as .env" -ForegroundColor Cyan
    Copy-Item -Path ".env.shared-hosting" -Destination "$tempFolder\.env"
}

# Buat ZIP file
$zipFileName = "village-web-$(Get-Date -Format 'yyyy-MM-dd-HHmm').zip"
Write-Host "🗜️  Creating ZIP file: $zipFileName" -ForegroundColor Yellow

if (Get-Command Compress-Archive -ErrorAction SilentlyContinue) {
    Compress-Archive -Path "$tempFolder\*" -DestinationPath $zipFileName -Force
} else {
    Write-Host "❌ Compress-Archive not available. Please use manual ZIP creation." -ForegroundColor Red
}

# Cleanup temporary folder
Remove-Item -Path $tempFolder -Recurse -Force

# Show file size
if (Test-Path $zipFileName) {
    $fileSize = [math]::Round((Get-Item $zipFileName).Length / 1MB, 2)
    Write-Host "✅ ZIP created successfully!" -ForegroundColor Green
    Write-Host "📁 File: $zipFileName ($fileSize MB)" -ForegroundColor Green
    Write-Host ""
    Write-Host "📋 NEXT STEPS:" -ForegroundColor Yellow
    Write-Host "1. Upload dan extract $zipFileName ke folder Laravel di hosting" -ForegroundColor White
    Write-Host "2. Edit .env file dengan kredensial database hosting" -ForegroundColor White
    Write-Host "3. Set permission 755 untuk folder storage/ dan bootstrap/cache/" -ForegroundColor White
    Write-Host "4. Run: php artisan migrate --force" -ForegroundColor White
    Write-Host "5. Run: php artisan db:seed --force" -ForegroundColor White
} else {
    Write-Host "❌ Failed to create ZIP file" -ForegroundColor Red
}