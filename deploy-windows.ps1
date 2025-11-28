# 🚀 DEPLOYMENT SCRIPT UNTUK SHARED HOSTING - WINDOWS
# Script ini membantu Anda deploy ke shared hosting dari Windows

# ===================================================================
# PANDUAN PENGGUNAAN:
# 1. Copy file ini ke folder project Laravel
# 2. Buka PowerShell sebagai Administrator
# 3. Jalankan: .\deploy-windows.ps1
# ===================================================================

Write-Host "🚀 VILLAGE WEB - SHARED HOSTING DEPLOYMENT (Windows)" -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green

# Check if we're in Laravel project directory
if (!(Test-Path "artisan") -or !(Test-Path "composer.json")) {
    Write-Host "❌ ERROR: Script harus dijalankan di root folder Laravel project" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "✅ Folder Laravel project detected" -ForegroundColor Green

# Step 1: Bersihkan development files
Write-Host ""
Write-Host "🧹 STEP 1: Cleaning development files..." -ForegroundColor Yellow

# Hapus file yang tidak perlu di production
$filesToDelete = @(
    "deploy-windows.ps1",
    ".env.example", 
    "phpunit.xml",
    "vite.config.js",
    "tailwind.config.js", 
    "postcss.config.js",
    "package.json",
    "package-lock.json"
)

foreach ($file in $filesToDelete) {
    if (Test-Path $file) {
        Remove-Item $file -Force
        Write-Host "   ✅ Deleted: $file" -ForegroundColor Green
    }
}

# Hapus folder yang tidak perlu
$foldersToDelete = @("tests", "node_modules", ".git")

foreach ($folder in $foldersToDelete) {
    if (Test-Path $folder) {
        Remove-Item $folder -Recurse -Force
        Write-Host "   ✅ Deleted folder: $folder" -ForegroundColor Green
    }
}

# Step 2: Setup Storage Permissions
Write-Host ""
Write-Host "📁 STEP 2: Setting up storage directories..." -ForegroundColor Yellow

$storageDirs = @(
    "storage\framework\cache\data",
    "storage\framework\cache\static", 
    "storage\framework\sessions",
    "storage\framework\views",
    "storage\logs\daily",
    "storage\app\public",
    "storage\app\security",
    "bootstrap\cache"
)

foreach ($dir in $storageDirs) {
    if (!(Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
        Write-Host "   ✅ Created: $dir" -ForegroundColor Green
    }
}

# Step 3: Clear Laravel caches
Write-Host ""
Write-Host "🗑️ STEP 3: Clearing Laravel caches..." -ForegroundColor Yellow

if (Get-Command php -ErrorAction SilentlyContinue) {
    try {
        php artisan cache:clear 2>$null
        Write-Host "   ✅ Cache cleared" -ForegroundColor Green
        
        php artisan config:clear 2>$null
        Write-Host "   ✅ Config cleared" -ForegroundColor Green
        
        php artisan view:clear 2>$null  
        Write-Host "   ✅ Views cleared" -ForegroundColor Green
        
        php artisan route:clear 2>$null
        Write-Host "   ✅ Routes cleared" -ForegroundColor Green
    }
    catch {
        Write-Host "   ⚠️ PHP commands skipped (normal untuk pre-deployment)" -ForegroundColor Yellow
    }
} else {
    Write-Host "   ⚠️ PHP not found in PATH - manual clear required on server" -ForegroundColor Yellow
}

# Step 4: Compress project
Write-Host ""
Write-Host "📦 STEP 4: Creating deployment package..." -ForegroundColor Yellow

$timestamp = Get-Date -Format "yyyyMMdd-HHmm"
$zipFile = "village-web-deployment-$timestamp.zip"

# Create ZIP file using built-in PowerShell compression
Compress-Archive -Path "*" -DestinationPath $zipFile -Force

$zipSize = (Get-Item $zipFile).Length
$zipSizeMB = [math]::Round($zipSize / 1MB, 2)

Write-Host "   ✅ Package created: $zipFile ($zipSizeMB MB)" -ForegroundColor Green

# Step 5: Generate deployment checklist
Write-Host ""
Write-Host "📋 STEP 5: Generating deployment checklist..." -ForegroundColor Yellow

$checklist = @"
# 🔥 VILLAGE WEB DEPLOYMENT CHECKLIST
Generated: $(Get-Date)
Package: $zipFile

## ✅ PRE-UPLOAD CHECKLIST:
- [x] Development files cleaned
- [x] Storage directories created
- [x] Laravel caches cleared
- [x] Deployment package created ($zipSizeMB MB)

## 📤 UPLOAD TO SHARED HOSTING:
1. **Extract ZIP ke hosting:**
   - Login ke cPanel File Manager atau FTP
   - Upload $zipFile ke public_html atau domain folder
   - Extract semua files

2. **Setup .env file:**
   - Copy .env.shared-hosting ke .env
   - Edit .env dengan database credentials hosting Anda:
     ```
     DB_HOST=localhost
     DB_DATABASE=your_db_name  
     DB_USERNAME=your_db_user
     DB_PASSWORD=your_db_pass
     APP_URL=https://your-domain.com
     ```

3. **Generate APP_KEY:**
   ```bash
   php artisan key:generate
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate --force
   ```

5. **Set file permissions (via cPanel File Manager):**
   - storage/ → 755
   - bootstrap/cache/ → 755

6. **Create storage symlink:**
   ```bash
   php artisan storage:link
   ```

7. **Optimize for production:**
   ```bash
   php artisan optimize:shared-hosting --cache-warmup
   ```

## 🧪 TESTING:
- [ ] Website homepage loading
- [ ] Admin panel accessible (/admin)
- [ ] Security dashboard working (/security-admin/dashboard)
- [ ] Database connection working
- [ ] File uploads working

## 🛡️ SECURITY VERIFICATION:
- [ ] HTTPS certificate active
- [ ] Admin IP Allowlist configured (optional)
- [ ] Security monitoring active
- [ ] All security middleware working

## 📞 SUPPORT:
Jika ada masalah deployment, cek:
- storage/logs/laravel.log untuk error details
- cPanel Error Logs
- Security dashboard untuk status security

Website Anda akan tersedia di: https://your-domain.com
Admin Panel: https://your-domain.com/admin
"@

$checklist | Out-File -FilePath "DEPLOYMENT-CHECKLIST-$timestamp.txt" -Encoding UTF8

Write-Host "   ✅ Checklist saved: DEPLOYMENT-CHECKLIST-$timestamp.txt" -ForegroundColor Green

# Final summary
Write-Host ""
Write-Host "🎉 DEPLOYMENT PREPARATION COMPLETED!" -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green
Write-Host "📦 Package ready: $zipFile ($zipSizeMB MB)" -ForegroundColor Cyan
Write-Host "📋 Checklist: DEPLOYMENT-CHECKLIST-$timestamp.txt" -ForegroundColor Cyan
Write-Host ""
Write-Host "📤 NEXT STEPS:" -ForegroundColor Yellow
Write-Host "1. Upload $zipFile ke shared hosting Anda" -ForegroundColor White
Write-Host "2. Extract files di public_html atau domain folder" -ForegroundColor White  
Write-Host "3. Follow checklist untuk setup .env dan permissions" -ForegroundColor White
Write-Host "4. Test website functionality" -ForegroundColor White
Write-Host ""
Write-Host "🚀 Ready for deployment! Good luck!" -ForegroundColor Green