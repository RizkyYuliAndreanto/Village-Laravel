# ⚡ EMAIL SECURITY ALERTS - QUICK SETUP (5 MENIT)

## 🎯 **JAWABAN SINGKAT: TIDAK HARUS BUAT EMAIL BARU!**

Anda bisa menggunakan **email yang sudah ada**:

-   ✅ Gmail pribadi Kades/Sekdes
-   ✅ Email desa yang sudah ada
-   ✅ Email hosting provider

---

## 🚀 **SETUP TERCEPAT: GUNAKAN GMAIL YANG ADA**

### **Step 1: Siapkan Gmail (2 menit)**

```
1. Buka Gmail yang ingin digunakan
2. Settings → Security → 2-Step Verification (enable)
3. App Passwords → Generate untuk "Mail"
4. Copy 16-digit password (contoh: abcd efgh ijkl mnop)
```

### **Step 2: Update .env (1 menit)**

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your_16_digit_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="Website Desa Security"

# Security Alerts
SECURITY_EMAIL_ALERTS=true
SECURITY_ADMIN_EMAIL=kades@gmail.com,sekdes@gmail.com
```

### **Step 3: Test (1 menit)**

```bash
php artisan config:clear
php artisan tinker
>>> Mail::raw('Test', function($m) { $m->to('your-email@gmail.com'); });
```

---

## 📧 **PILIHAN EMAIL YANG BISA DIGUNAKAN**

### **🥇 Gmail Pribadi (TERMUDAH)**

```env
SECURITY_ADMIN_EMAIL=kades.banyukambang@gmail.com
```

-   ✅ Gratis & reliable
-   ✅ Easy setup (5 menit)
-   ✅ Mobile notifications

### **🥈 Email Desa Existing**

```env
SECURITY_ADMIN_EMAIL=admin@desa-banyukambang.id
```

-   ✅ Professional
-   ✅ Tidak perlu buat baru
-   ⚠️ Perlu SMTP settings dari hosting

### **🥉 Multiple Recipients**

```env
SECURITY_ADMIN_EMAIL=kades@gmail.com,sekdes@gmail.com,kaur@gmail.com
```

-   ✅ Semua dapat notifikasi
-   ✅ Backup jika salah satu tidak aktif

---

## 📊 **JENIS ALERT YANG DIKIRIM**

### **🚨 Critical Alerts (RECOMMENDED)**

```env
SECURITY_ALERT_LEVEL=critical
```

**Akan dapat email untuk:**

-   Brute force attacks
-   Successful breach attempts
-   System tampering

### **📧 Daily Summary (MINIMAL)**

```env
SECURITY_ALERT_LEVEL=summary
```

**Akan dapat:**

-   1 email per hari ringkasan
-   Tidak spam inbox

---

## 🚫 **OPSI: DISABLE EMAIL ALERTS**

```env
# Jika tidak mau setup email sama sekali
SECURITY_EMAIL_ALERTS=false

# Monitoring manual via dashboard saja:
# https://your-domain.com/security-admin/dashboard
```

---

## 🔧 **TROUBLESHOOTING 30 DETIK**

### **Email tidak terkirim?**

```bash
# Check error
tail storage/logs/laravel.log | grep -i mail
```

### **Gmail tidak work?**

1. ✅ Pastikan 2FA enabled
2. ✅ Use App Password (bukan password Gmail)
3. ✅ Copy exact 16-digit code

---

## 🎯 **REKOMENDASI UNTUK DESA**

### **PALING SIMPLE:**

```env
SECURITY_EMAIL_ALERTS=false  # Disable email
# Check manual: /security-admin/dashboard (weekly)
```

### **RECOMMENDED:**

```env
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=critical
SECURITY_ADMIN_EMAIL=kades@gmail.com
# + Setup Gmail dengan App Password
```

### **COMPREHENSIVE:**

```env
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=all
SECURITY_ADMIN_EMAIL=kades@gmail.com,sekdes@gmail.com,admin@desa.id
```

---

**💡 BOTTOM LINE: Gunakan Gmail pribadi yang sudah ada. Setup 5 menit, dapat notifikasi security real-time! 📧⚡**
