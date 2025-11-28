# 🔧 ADMIN IP ALLOWLIST - QUICK SETUP GUIDE

## ⚡ **SETUP CEPAT 5 MENIT**

### **Step 1: Cari IP Address Anda**

```bash
# Method termudah:
curl ifconfig.me
# Output: 203.0.113.10
```

### **Step 2: Edit File .env**

```env
# Tambahkan di file .env
ADMIN_IP_ALLOWLIST=127.0.0.1,203.0.113.10
```

### **Step 3: Clear Cache**

```bash
php artisan config:clear
php artisan cache:clear
```

### **Step 4: Test Access**

-   Buka `/admin` di browser
-   Harus bisa akses normal
-   Test dari IP lain (harus blocked)

---

## 🏠 **CONTOH KONFIGURASI POPULER**

### **Home + Office**

```env
ADMIN_IP_ALLOWLIST=127.0.0.1,203.0.113.10,198.51.100.25
```

### **Network Range (Kantor)**

```env
ADMIN_IP_ALLOWLIST=192.168.1.0/24,203.0.113.10
```

### **Multiple Locations**

```env
ADMIN_IP_ALLOWLIST=203.0.113.0/24,198.51.100.0/24
```

---

## 🚨 **EMERGENCY ACCESS**

Jika terkunci dari admin:

```env
# Method 1: Add your current IP
ADMIN_IP_ALLOWLIST=127.0.0.1,YOUR_CURRENT_IP

# Method 2: Temporary local mode
APP_ENV=local
```

---

## 📊 **MONITORING**

### **Security Dashboard:**

-   URL: `/security-admin/dashboard`
-   Monitor blocked attempts
-   View security logs

### **Check Logs:**

```bash
tail -f storage/logs/security.log
```

---

## ⚙️ **ADVANCED CONFIG**

### **Environment Behavior:**

-   **Local (`APP_ENV=local`)**: IP Allowlist **DISABLED**
-   **Production (`APP_ENV=production`)**: IP Allowlist **ENABLED**

### **Protected Routes:**

-   `/admin/*` (Filament)
-   `/dashboard/*`
-   `/manage/*`
-   `/control-panel/*`

### **IP Detection Features:**

-   ✅ Cloudflare support
-   ✅ Proxy detection
-   ✅ Load balancer support
-   ✅ CIDR notation support

---

## 🔍 **TROUBLESHOOTING**

### **Problem: Access Denied**

```bash
# 1. Check your current IP
curl ifconfig.me

# 2. Check config
php artisan tinker
>>> config('security.admin_ip_allowlist')

# 3. Check logs
tail storage/logs/security.log
```

### **Problem: IP Berubah**

```env
# Solution: Use IP range
ADMIN_IP_ALLOWLIST=203.0.113.0/24
```

---

**📋 Complete Guide: `/documentation/ADMIN_IP_ALLOWLIST_GUIDE.md`**
