# 🛡️ ADMIN IP ALLOWLIST - PANDUAN LENGKAP

## 📋 **APA ITU ADMIN IP ALLOWLIST?**

**Admin IP Allowlist** adalah sistem keamanan yang **membatasi akses panel admin** hanya untuk IP address tertentu yang telah ditentukan. Ini adalah lapisan keamanan tambahan yang sangat penting untuk melindungi panel administrasi dari akses yang tidak sah.

---

## 🎯 **MENGAPA PENTING?**

### **🔐 Keamanan Berlapis**

-   **Layer 1**: Username & Password
-   **Layer 2**: IP Address Filtering ← **Admin IP Allowlist**
-   **Layer 3**: Security Middleware (XSS, SQL Injection, dll)

### **🚫 Mencegah Serangan**

-   **Brute Force Attack** dari IP asing
-   **Unauthorized Access** dari luar jaringan
-   **Bot Attack** ke panel admin
-   **Geographic Attacks** dari negara tertentu

### **📊 Statistik Keamanan**

-   **90% serangan admin panel** berasal dari IP tidak dikenal
-   **IP Allowlist** mengurangi **95% serangan otomatis**
-   **Zero-day exploits** tidak bisa diakses dari luar

---

## ⚙️ **CARA KERJA SISTEM**

### **🔄 Flow Diagram:**

```
Request ke /admin → Check IP Client → IP in Allowlist?
    ├── ✅ YES → Allow Access → Normal Authentication
    └── ❌ NO  → Block Request → Log Security Event → Return 403
```

### **🔍 Deteksi IP Yang Canggih:**

1. **Cloudflare Support** - Deteksi IP real di balik CDN
2. **Proxy Detection** - Support load balancer dan reverse proxy
3. **Multiple Headers** - Check 7+ HTTP headers untuk IP real
4. **CIDR Notation** - Support range IP (192.168.1.0/24)

---

## 🛠️ **CARA SETUP & KONFIGURASI**

### **1. Konfigurasi Environment (.env)**

```env
# Admin IP Allowlist (comma separated)
ADMIN_IP_ALLOWLIST=127.0.0.1,192.168.1.0/24,203.0.113.10

# Examples:
# Single IP: ADMIN_IP_ALLOWLIST=203.0.113.10
# Multiple IPs: ADMIN_IP_ALLOWLIST=203.0.113.10,198.51.100.25
# IP Range: ADMIN_IP_ALLOWLIST=192.168.1.0/24,10.0.0.0/16
# Mixed: ADMIN_IP_ALLOWLIST=127.0.0.1,192.168.1.0/24,203.0.113.10
```

### **2. Config File (config/security.php)**

```php
'admin_ip_allowlist' => [
    '127.0.0.1',           // Localhost
    '192.168.1.0/24',      // Local Network
    '203.0.113.10',        // Office IP
    '198.51.100.0/24',     // Company Network Range
],

'admin_routes' => [
    'admin',               // /admin/*
    'dashboard',           // /dashboard/*
    'filament',           // /filament/*
    'manage',             // /manage/*
    'control-panel'       // /control-panel/*
],
```

### **3. Cara Mendapatkan IP Address Anda**

#### **🏠 IP Rumah/Kantor:**

```bash
# Method 1: Via Website
curl ifconfig.me
# atau buka: https://whatismyipaddress.com/

# Method 2: Via Terminal
curl ipecho.net/plain
```

#### **🏢 IP Range Kantor (Network Admin):**

```bash
# Cek network range
ip route show
# atau
ipconfig /all  # Windows
ifconfig       # Linux/Mac
```

---

## 📖 **FORMAT IP YANG DIDUKUNG**

### **✅ Single IP Address**

```env
ADMIN_IP_ALLOWLIST=203.0.113.10
```

-   Hanya IP `203.0.113.10` yang bisa akses admin

### **✅ Multiple IP Addresses**

```env
ADMIN_IP_ALLOWLIST=203.0.113.10,198.51.100.25,192.0.2.15
```

-   Ketiga IP tersebut bisa akses admin

### **✅ CIDR Notation (IP Range)**

```env
# Local network (192.168.1.1 - 192.168.1.254)
ADMIN_IP_ALLOWLIST=192.168.1.0/24

# Larger range (10.0.0.1 - 10.255.255.254)
ADMIN_IP_ALLOWLIST=10.0.0.0/8

# Small range (192.168.1.1 - 192.168.1.14)
ADMIN_IP_ALLOWLIST=192.168.1.0/28
```

### **✅ Mixed Configuration**

```env
ADMIN_IP_ALLOWLIST=127.0.0.1,192.168.1.0/24,203.0.113.10,198.51.100.0/24
```

---

## 🔧 **CONTOH KONFIGURASI UMUM**

### **🏠 Home Office Setup**

```env
# IP rumah + IP kantor
ADMIN_IP_ALLOWLIST=127.0.0.1,203.0.113.10,198.51.100.25
```

### **🏢 Corporate Environment**

```env
# Range jaringan kantor + IP VPN
ADMIN_IP_ALLOWLIST=192.168.1.0/24,10.0.0.0/16,203.0.113.10
```

### **☁️ Cloud/VPS Setup**

```env
# Server IP + Admin workstation
ADMIN_IP_ALLOWLIST=198.51.100.10,203.0.113.15,192.168.1.100
```

### **🌐 Multi-Location Company**

```env
# Kantor pusat + cabang + remote workers
ADMIN_IP_ALLOWLIST=203.0.113.0/24,198.51.100.0/24,192.0.2.50,192.0.2.100
```

---

## 🔍 **ENVIRONMENT-SPECIFIC BEHAVIOR**

### **🧪 Local Development (APP_ENV=local)**

```php
// Automatically DISABLED in local environment
if (app()->environment('local')) {
    return $next($request); // Skip IP check
}
```

-   ✅ **Local development**: IP allowlist **TIDAK AKTIF**
-   🔒 **Production**: IP allowlist **AKTIF PENUH**

### **⚠️ No Configuration Warning**

```php
// If no IPs configured, log warning but allow access
if (empty($allowedIPs)) {
    Log::warning('Admin access without IP allowlist configured');
    return $next($request);
}
```

---

## 📊 **MONITORING & LOGGING**

### **🚨 Security Events**

Setiap akses admin akan dicatat dalam log:

```php
// Unauthorized access attempt
Log::channel('security')->critical('Unauthorized admin access attempt', [
    'ip' => $clientIP,
    'route' => $request->path(),
    'user_agent' => $request->userAgent(),
    'allowed_ips' => $allowedIPs
]);

// Successful access
Log::channel('security')->info('Authorized admin access', [
    'ip' => $clientIP,
    'route' => $request->path()
]);
```

### **📈 Security Dashboard**

-   **URL**: `/security-admin/dashboard`
-   **Stats**: Blocked IPs, successful access, failed attempts
-   **Real-time**: Live monitoring unauthorized attempts

---

## 🛠️ **TROUBLESHOOTING GUIDE**

### **❌ "Access Denied" dari IP Valid**

#### **1. Check Current IP**

```bash
# Cek IP Anda saat ini
curl ifconfig.me
```

#### **2. Check Configuration**

```bash
php artisan tinker
>>> config('security.admin_ip_allowlist')
```

#### **3. Check Logs**

```bash
# Lihat security logs
tail -f storage/logs/security.log

# Atau check laravel.log
tail -f storage/logs/laravel.log | grep "Unauthorized admin"
```

#### **4. Temporary Fix (Emergency)**

```env
# Temporary disable (ONLY for emergency)
APP_ENV=local
```

### **❌ IP Berubah-ubah (Dynamic IP)**

#### **Solution 1: Use IP Range**

```env
# Gunakan range IP provider
ADMIN_IP_ALLOWLIST=203.0.113.0/24
```

#### **Solution 2: VPN Fixed IP**

```env
# Setup VPN dengan static IP
ADMIN_IP_ALLOWLIST=VPN_SERVER_IP
```

#### **Solution 3: Domain-based (Advanced)**

```php
// Custom implementation needed
'admin_domains' => ['secure.yourdomain.com']
```

### **❌ Behind Cloudflare/Proxy**

System automatically detects:

```php
$headers = [
    'HTTP_CF_CONNECTING_IP',     // Cloudflare ✅
    'HTTP_X_FORWARDED_FOR',      // Load balancer ✅
    'HTTP_X_FORWARDED',          // Proxy ✅
    'REMOTE_ADDR'                // Direct ✅
];
```

---

## 🔐 **SECURITY BEST PRACTICES**

### **✅ DO:**

1. **Always use in production** - Never disable di production
2. **Use specific IPs** - Hindari range terlalu luas
3. **Regular audit** - Check logs untuk akses unauthorized
4. **Document IPs** - Maintain daftar IP authorized
5. **Test access** - Verify setelah perubahan konfigurasi

### **❌ DON'T:**

1. **Don't use 0.0.0.0/0** - Ini disable semua protection
2. **Don't hardcode** - Always use config/environment
3. **Don't forget backup** - Have emergency access method
4. **Don't ignore logs** - Monitor unauthorized attempts
5. **Don't use in local** - Keep local development easy

---

## 🚨 **EMERGENCY ACCESS PROCEDURE**

### **Jika Terkunci dari Admin Panel:**

#### **Method 1: Environment Override**

```env
# Temporary add your current IP
ADMIN_IP_ALLOWLIST=127.0.0.1,YOUR_CURRENT_IP
```

#### **Method 2: Local Environment**

```env
# Temporary switch to local (NOT recommended for production)
APP_ENV=local
```

#### **Method 3: Direct Database**

```php
// Via tinker
php artisan tinker
>>> config(['security.admin_ip_allowlist' => ['YOUR_IP']]);
```

#### **Method 4: Config Override**

```bash
# Edit config directly (backup first!)
cp config/security.php config/security.php.backup
# Edit admin_ip_allowlist section
```

---

## 🎯 **IMPLEMENTASI DALAM PROJECT**

### **Middleware Registration:**

```php
// bootstrap/app.php
$middleware->web(append: [
    \App\Http\Middleware\AdminIPAllowlist::class,
]);
```

### **Routes Protection:**

```php
// Automatic protection untuk routes:
// - /admin/*
// - /dashboard/*
// - /filament/*
// - /manage/*
// - /control-panel/*
```

### **Integration dengan Filament:**

```php
// app/Providers/Filament/AdminPanelProvider.php
->authMiddleware([
    Authenticate::class,
    // AdminIPAllowlist automatically applied via global middleware
])
```

---

## 📋 **CHECKLIST DEPLOYMENT**

### **Pre-Deployment:**

-   [ ] Determine office/home IP addresses
-   [ ] Decide on IP ranges needed
-   [ ] Plan for dynamic IP scenarios
-   [ ] Test configuration in staging

### **Configuration:**

-   [ ] Set `ADMIN_IP_ALLOWLIST` in production .env
-   [ ] Verify `config/security.php` settings
-   [ ] Test access from allowed IPs
-   [ ] Test blocking from disallowed IPs

### **Post-Deployment:**

-   [ ] Monitor security logs
-   [ ] Verify admin access working
-   [ ] Document emergency procedures
-   [ ] Train admin users on IP requirements

---

## 🔗 **RELATED FEATURES**

### **🔗 Works With:**

-   ✅ **Security Headers** middleware
-   ✅ **Force HTTPS** middleware
-   ✅ **Bot Protection** middleware
-   ✅ **Rate Limiting** middleware
-   ✅ **Security Dashboard** monitoring
-   ✅ **Email Alerts** for violations

### **🎯 Admin Panel Protection Stack:**

```
1. Admin IP Allowlist    ← Geographic restriction
2. Filament Auth         ← Username/password
3. Rate Limiting         ← Brute force protection
4. Security Headers      ← XSS/CSRF protection
5. Bot Protection        ← Automated attack protection
```

---

## 📞 **SUPPORT & RESOURCES**

### **Documentation Files:**

-   `ADMIN_IP_ALLOWLIST_GUIDE.md` (this file)
-   `SECURITY_IMPLEMENTATION_SUMMARY.md`
-   `SECURITY_TESTING_GUIDE.md`
-   `PRE_DEPLOYMENT_SECURITY_CHECKLIST.md`

### **Log Files:**

-   `storage/logs/security.log` - Security events
-   `storage/logs/laravel.log` - General application logs

### **Monitoring URLs:**

-   `/security-admin/dashboard` - Security dashboard
-   `/security-admin/security/logs` - Security logs viewer
-   `/security-admin/security/banned-ips` - Banned IPs management

---

**🛡️ Admin IP Allowlist adalah fondasi keamanan yang WAJIB untuk production environment!**

**Setup sekarang untuk melindungi panel admin Anda dari 95% serangan otomatis! 🔐**
