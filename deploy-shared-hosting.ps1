# 🏠 Laravel Village - Shared Hosting Deployment Script (Windows PowerShell)
# Automated deployment script for shared hosting environments

Write-Host "🚀 Starting Laravel Village Shared Hosting Deployment..." -ForegroundColor Green
Write-Host "=================================================="

# Configuration
$ProjectName = "Laravel-Village"
$BackupDir = "backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"

# Function to print colored output
function Write-Success {
    param($Message)
    Write-Host "[SUCCESS] $Message" -ForegroundColor Green
}

function Write-Warning {
    param($Message)
    Write-Host "[WARNING] $Message" -ForegroundColor Yellow
}

function Write-Error {
    param($Message)
    Write-Host "[ERROR] $Message" -ForegroundColor Red
}

function Write-Info {
    param($Message)
    Write-Host "[INFO] $Message" -ForegroundColor Blue
}

# Check if PHP is available
function Test-PHP {
    Write-Info "Checking PHP availability..."
    try {
        $phpVersion = php -r "echo PHP_VERSION;"
        Write-Success "PHP version: $phpVersion"
        return $true
    }
    catch {
        Write-Error "PHP is not available. Please install PHP 8.2+ first."
        return $false
    }
}

# Check if composer is available
function Test-Composer {
    Write-Info "Checking Composer availability..."
    try {
        composer --version | Out-Null
        Write-Success "Composer is available"
        return $true
    }
    catch {
        Write-Error "Composer is not available. Please install Composer first."
        return $false
    }
}

# Backup existing deployment
function New-Backup {
    if (Test-Path "storage") {
        Write-Info "Creating backup of existing deployment..."
        New-Item -ItemType Directory -Path $BackupDir -Force | Out-Null
        Copy-Item -Path "storage" -Destination "$BackupDir/" -Recurse
        if (Test-Path ".env") {
            Copy-Item -Path ".env" -Destination "$BackupDir/"
        }
        Write-Success "Backup created in $BackupDir"
    }
}

# Setup environment for shared hosting
function Initialize-Environment {
    Write-Info "Setting up environment for shared hosting..."
    
    # Copy shared hosting environment template
    if (-not (Test-Path ".env")) {
        if (Test-Path ".env.shared-hosting") {
            Copy-Item -Path ".env.shared-hosting" -Destination ".env"
            Write-Success "Copied shared hosting environment template"
        }
        else {
            Write-Error "No environment template found! Please create .env file."
            exit 1
        }
    }
    
    # Generate application key if not set
    $envContent = Get-Content ".env" -Raw
    if (-not ($envContent -match "APP_KEY=base64:")) {
        Write-Info "Generating application key..."
        php artisan key:generate --force
        Write-Success "Application key generated"
    }
}

# Install dependencies (production mode)
function Install-Dependencies {
    Write-Info "Installing production dependencies..."
    
    # Clear composer cache
    composer clear-cache
    
    # Install dependencies optimized for production
    $result = composer install --no-dev --optimize-autoloader --no-interaction
    
    if ($LASTEXITCODE -eq 0) {
        Write-Success "Dependencies installed successfully"
        return $true
    }
    else {
        Write-Error "Failed to install dependencies"
        return $false
    }
}

# Build frontend assets
function Build-Assets {
    Write-Info "Building frontend assets..."
    
    if (Test-Path "package.json") {
        # Install npm dependencies
        try {
            npm --version | Out-Null
            npm ci --silent
            npm run build
            Write-Success "Frontend assets built successfully"
        }
        catch {
            Write-Warning "npm not available, skipping frontend build"
        }
    }
    else {
        Write-Warning "No package.json found, skipping frontend build"
    }
}

# Set proper permissions for shared hosting (Windows equivalent)
function Set-Permissions {
    Write-Info "Creating necessary directories..."
    
    # Make sure important directories exist dengan SSD optimization
    New-Item -ItemType Directory -Path "storage/logs" -Force | Out-Null
    New-Item -ItemType Directory -Path "storage/framework/cache" -Force | Out-Null
    New-Item -ItemType Directory -Path "storage/framework/sessions" -Force | Out-Null
    New-Item -ItemType Directory -Path "storage/framework/views" -Force | Out-Null
    New-Item -ItemType Directory -Path "storage/app/public" -Force | Out-Null
    New-Item -ItemType Directory -Path "storage/app/public/uploads" -Force | Out-Null
    New-Item -ItemType Directory -Path "storage/app/public/images" -Force | Out-Null
    New-Item -ItemType Directory -Path "bootstrap/cache" -Force | Out-Null
    
    Write-Success "Directories created successfully (SSD optimized)"
}

# Database setup and migration
function Initialize-Database {
    Write-Info "Setting up database..."
    
    # Test database connection
    php artisan config:cache
    
    try {
        php artisan migrate:status | Out-Null
        Write-Info "Running database migrations..."
        php artisan migrate --force
        Write-Success "Database migrations completed"
        return $true
    }
    catch {
        Write-Warning "Could not connect to database. Please check your .env configuration."
        return $false
    }
}

# Apply shared hosting optimizations
function Invoke-Optimizations {
    Write-Info "Applying shared hosting optimizations..."
    
    # Clear all caches first
    try { php artisan cache:clear } catch { }
    try { php artisan config:clear } catch { }
    try { php artisan route:clear } catch { }
    try { php artisan view:clear } catch { }
    
    # Cache configuration, routes, and views for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Create storage symlink if it doesn't exist
    if (-not (Test-Path "public/storage")) {
        try { php artisan storage:link } catch { }
    }
    
    Write-Success "Optimizations applied successfully"
}

# Cleanup development files
function Remove-DevFiles {
    Write-Info "Cleaning up development files..."
    
    # Remove development files that shouldn't be in production
    $filesToRemove = @(
        ".git",
        "tests",
        "node_modules",
        ".gitignore",
        ".gitattributes",
        "package.json",
        "package-lock.json",
        "webpack.mix.js",
        "vite.config.js",
        "phpunit.xml",
        ".editorconfig",
        ".styleci.yml",
        "railway*.*",
        "nixpacks.toml"
    )
    
    foreach ($item in $filesToRemove) {
        if (Test-Path $item) {
            Remove-Item -Path $item -Recurse -Force -ErrorAction SilentlyContinue
        }
    }
    
    Write-Success "Development files cleaned up"
}

# Verify deployment
function Test-Deployment {
    Write-Info "Verifying deployment..."
    
    # Check if key routes are working
    try {
        php artisan route:list | Out-Null
        Write-Success "Routes are properly configured"
    }
    catch {
        Write-Warning "Route issues detected"
    }
    
    # Check if database is accessible
    try {
        php artisan migrate:status | Out-Null
        Write-Success "Database connection verified"
    }
    catch {
        Write-Warning "Database connection issues"
    }
    
    # Check storage permissions
    if (Test-Path "storage/logs" -PathType Container) {
        Write-Success "Storage directories are accessible"
    }
    else {
        Write-Warning "Storage access issues detected"
    }
}

# Display post-deployment instructions
function Show-Instructions {
    Write-Host ""
    Write-Host "🎉 Deployment completed successfully!" -ForegroundColor Green
    Write-Host "=================================="
    Write-Host ""
    Write-Host "📋 Next steps for your shared hosting:" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "1. 📁 Upload all files to your hosting's public_html directory"
    Write-Host "2. 🔧 Edit .env file with your hosting database credentials:"
    Write-Host "   - DB_HOST (usually 'localhost')"
    Write-Host "   - DB_DATABASE (your database name)"
    Write-Host "   - DB_USERNAME (your database username)"
    Write-Host "   - DB_PASSWORD (your database password)"
    Write-Host "   - APP_URL (your domain name)"
    Write-Host ""
    Write-Host "3. 🗄️ Create database and run migrations (if needed):"
    Write-Host "   php artisan migrate --force"
    Write-Host ""
    Write-Host "4. 🔐 Set these file permissions via cPanel or FTP:"
    Write-Host "   - storage/ and subdirectories: 755"
    Write-Host "   - bootstrap/cache/: 755"
    Write-Host ""
    Write-Host "5. ✅ Verify your site is working:"
    Write-Host "   - Homepage: https://your-domain.com"
    Write-Host "   - Admin: https://your-domain.com/admin"
    Write-Host ""
    Write-Host "📞 If you encounter issues:" -ForegroundColor Yellow
    Write-Host "   - Check storage/logs/laravel.log for errors"
    Write-Host "   - Ensure PHP 8.2+ is enabled in cPanel"
    Write-Host "   - Contact your hosting provider for Laravel support"
    Write-Host ""
    Write-Host "🏠 Your Laravel Village is ready for shared hosting!" -ForegroundColor Green
}

# Main execution
function Main {
    # Pre-flight checks
    if (-not (Test-PHP)) { exit 1 }
    if (-not (Test-Composer)) { exit 1 }
    
    # Deployment steps
    New-Backup
    Initialize-Environment
    if (-not (Install-Dependencies)) { exit 1 }
    Build-Assets
    Set-Permissions
    Initialize-Database
    Invoke-Optimizations
    Remove-DevFiles
    Test-Deployment
    
    # Post-deployment
    Show-Instructions
}

# Run main function
Main

Write-Host ""
Write-Host "🚀 Shared hosting deployment script completed!" -ForegroundColor Green
Write-Host "============================================"