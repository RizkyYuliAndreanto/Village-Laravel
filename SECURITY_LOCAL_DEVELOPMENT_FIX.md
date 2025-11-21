# 🔧 DEBUGGING SECURITY MIDDLEWARE - LOCAL DEVELOPMENT

## ❗ MASALAH YANG TERJADI:

Saat development local, middleware security terlalu ketat dan memblokir request normal dengan pesan:

```json
{ "error": "Request blocked", "message": "Suspicious activity detected" }
```

## ✅ SOLUSI YANG TELAH DITERAPKAN:

### 1. **Environment Check di Setiap Middleware**

Semua middleware security sekarang mengecek environment dan **skip di local development**:

```php
// Skip security checks in local development
if (app()->environment('local')) {
    return $next($request);
}
```

### 2. **Middleware yang Telah Dimodifikasi:**

-   ✅ `DetectSuspiciousRequest.php` - Skip threat detection
-   ✅ `BlockMaliciousBots.php` - Skip bot blocking
-   ✅ `AdminIPAllowlist.php` - Skip IP allowlist
-   ✅ `RefererCheck.php` - Skip referer validation
-   ✅ `AntiXSSMiddleware.php` - Skip strict XSS detection

### 3. **Environment Variables (.env):**

```env
APP_ENV=local
APP_DEBUG=true
FORCE_HTTPS=false
FORCE_HTTPS_LOCAL=false
SECURITY_EMAIL_ALERTS=false
SECURITY_DEV_MODE=true
```

## 🧪 TESTING LOCAL DEVELOPMENT:

### 1. **Akses Homepage:**

```bash
curl http://localhost:8000/
```

✅ **Harus berjalan normal tanpa blocking**

### 2. **Akses Admin Dashboard:**

```bash
curl http://localhost:8000/admin
```

✅ **Harus bisa diakses tanpa IP allowlist**

### 3. **Test dengan Browser:**

-   Homepage: `http://localhost:8000/`
-   Profil Desa: `http://localhost:8000/profil-desa`
-   Admin: `http://localhost:8000/admin`

## 🚀 START SERVER:

```bash
cd "d:\PROJECT\Laravel-web\Village-web"
php artisan serve --port=8000
```

Server akan berjalan di: `http://127.0.0.1:8000`

## 🔍 DEBUGGING STEPS:

### 1. **Check Environment:**

```bash
php artisan tinker
>>> app()->environment()
# Harus return: "local"
```

### 2. **Clear All Cache:**

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 3. **Check Middleware Registration:**

```bash
php artisan route:list --path=admin
```

### 4. **Test Specific Route:**

```bash
# Test homepage
curl -v http://localhost:8000/

# Test admin (should work now)
curl -v http://localhost:8000/admin
```

## 🛡️ PRODUCTION MODE:

Untuk **production**, ubah `.env`:

```env
APP_ENV=production
APP_DEBUG=false
FORCE_HTTPS=true
SECURITY_EMAIL_ALERTS=true
SECURITY_ADMIN_EMAIL=admin@yourdomain.com
```

Di production, semua middleware security akan **aktif penuh**.

## 📋 CHECKLIST TROUBLESHOOTING:

-   [x] APP_ENV = "local" di .env
-   [x] APP_DEBUG = true
-   [x] Clear semua cache
-   [x] Middleware skip di local environment
-   [x] No IP allowlist di local
-   [x] No bot blocking di local
-   [x] No suspicious request blocking di local

## 🎯 HASIL AKHIR:

**✅ Development Local**: Middleware security **disabled** untuk kenyamanan development
**🛡️ Production**: Middleware security **fully active** untuk perlindungan maksimal

Sekarang Anda bisa development dengan bebas di localhost tanpa terblokir security middleware! 🚀

---

**Note**: Jika masih ada masalah, restart Laravel server:

```bash
Ctrl+C (stop server)
php artisan serve --port=8000
```
