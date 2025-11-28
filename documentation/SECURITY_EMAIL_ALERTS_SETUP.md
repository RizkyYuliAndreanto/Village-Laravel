# 📧 SECURITY EMAIL ALERTS - PANDUAN SETUP

## 📋 **APA ITU SECURITY EMAIL ALERTS?**

**Security Email Alerts** adalah sistem yang mengirim **notifikasi email otomatis** ketika terjadi **aktivitas security** yang mencurigakan di website desa, seperti:

-   🚨 **Login mencurigakan** dari IP tidak dikenal
-   🔓 **Percobaan brute force** ke admin panel
-   🛡️ **Serangan XSS/SQL Injection** yang terdeteksi
-   🤖 **Bot attack** yang diblokir
-   📊 **Summary harian** aktivitas security

---

## 📧 **OPSI EMAIL YANG BISA DIGUNAKAN**

### **✅ Opsi 1: Email Desa yang Sudah Ada**

```env
# Gunakan email kantor/desa yang sudah ada
SECURITY_ADMIN_EMAIL=admin@desa-banyukambang.id
# atau
SECURITY_ADMIN_EMAIL=sekdes@desa-banyukambang.id
# atau
SECURITY_ADMIN_EMAIL=kades@desa-banyukambang.id
```

### **✅ Opsi 2: Gmail Pribadi (Paling Mudah)**

```env
# Gunakan Gmail pribadi Kades/Sekdes
SECURITY_ADMIN_EMAIL=kades.banyukambang@gmail.com
# atau
SECURITY_ADMIN_EMAIL=sekdes.banyukambang@gmail.com
```

### **✅ Opsi 3: Email Provider Hosting**

```env
# Biasanya hosting provider menyediakan email gratis
SECURITY_ADMIN_EMAIL=admin@your-domain.com
# atau
SECURITY_ADMIN_EMAIL=security@your-domain.com
```

### **✅ Opsi 4: Multiple Email Recipients**

```env
# Kirim ke beberapa email sekaligus
SECURITY_ADMIN_EMAIL=kades@gmail.com,sekdes@gmail.com,admin@desa.id
```

---

## 🎯 **REKOMENDASI UNTUK PEMERINTAHAN DESA**

### **🥇 RECOMMENDED: Gmail Pribadi + Email Desa**

```env
# Setup yang paling praktis untuk desa
SECURITY_EMAIL_ALERTS=true
SECURITY_ADMIN_EMAIL=kades.desa@gmail.com,admin@desa-banyukambang.id

# SMTP Gmail (gratis dan reliable)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=website.desa.banyukambang@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=website.desa.banyukambang@gmail.com
MAIL_FROM_NAME="Website Desa Banyukambang - Security Alert"
```

### **🥈 ALTERNATIVE: Hosting Email (jika tersedia)**

```env
# Jika hosting menyediakan email service
SECURITY_ADMIN_EMAIL=admin@your-domain.com

MAIL_MAILER=smtp
MAIL_HOST=mail.your-hosting-provider.com
MAIL_PORT=587
MAIL_USERNAME=admin@your-domain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
```

---

## 🛠️ **SETUP GMAIL UNTUK DESA (STEP-BY-STEP)**

### **Step 1: Buat Gmail untuk Website Desa**

1. **Buka**: https://accounts.google.com/signup
2. **Username**: `website.desa.banyukambang@gmail.com`
3. **Password**: Strong password (simpan di tempat aman)
4. **Recovery**: Gunakan email pribadi Kades/Sekdes

### **Step 2: Enable App Password**

1. **Masuk Gmail** → Settings → Security
2. **Enable 2-Step Verification** (wajib untuk App Password)
3. **Generate App Password**:
    - Go to: https://myaccount.google.com/apppasswords
    - Select: Mail
    - Device: Website Desa
    - **Copy 16-digit password** (contoh: `abcd efgh ijkl mnop`)

### **Step 3: Configure di .env**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=website.desa.banyukambang@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop  # App password (bukan password Gmail)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=website.desa.banyukambang@gmail.com
MAIL_FROM_NAME="Website Desa Banyukambang - Security"

# Email tujuan alerts
SECURITY_EMAIL_ALERTS=true
SECURITY_ADMIN_EMAIL=kades.desa@gmail.com,sekdes.desa@gmail.com
```

---

## 📋 **CONTOH EMAIL ALERT YANG DIKIRIM**

### **🚨 Sample: Brute Force Attack Alert**

```
From: Website Desa Banyukambang - Security <website.desa.banyukambang@gmail.com>
To: kades.desa@gmail.com
Subject: [SECURITY ALERT] Percobaan Login Mencurigakan - Website Desa

Kepada Bapak/Ibu Kepala Desa,

Sistem keamanan website desa mendeteksi aktivitas mencurigakan:

🚨 ALERT: Percobaan Brute Force Attack
📅 Waktu: 26 November 2025, 14:30 WIB
🌐 IP: 192.0.2.100 (Jakarta, Indonesia)
📍 Target: /admin (Panel Administrator)
🔄 Percobaan: 15 kali login gagal dalam 5 menit

✅ TINDAKAN OTOMATIS:
- IP telah diblokir otomatis selama 6 jam
- Semua akses dari IP tersebut ditolak
- Aktivitas dicatat dalam log security

📊 DASHBOARD SECURITY:
Lihat detail: https://desa-banyukambang.id/security-admin/dashboard

Salam,
Sistem Security Website Desa Banyukambang
```

### **📊 Sample: Daily Security Summary**

```
From: Website Desa Banyukambang - Security
To: kades.desa@gmail.com,sekdes.desa@gmail.com
Subject: [DAILY REPORT] Ringkasan Keamanan Harian - 26 Nov 2025

Ringkasan Keamanan Website Desa:
📅 Tanggal: 26 November 2025

✅ AKTIVITAS NORMAL:
- Login admin berhasil: 12 kali
- Pengunjung website: 245 orang
- Halaman paling populer: Berita Desa

⚠️ AKTIVITAS SECURITY:
- IP diblokir otomatis: 3 IP
- Percobaan SQL injection: 2 (diblokir)
- Bot attack: 5 (diblokir)

🛡️ SISTEM STATUS: AMAN
Dashboard: https://desa-banyukambang.id/security-admin/dashboard
```

---

## ⚙️ **KONFIGURASI LEVEL ALERT**

### **Level 1: Critical Only (RECOMMENDED untuk Desa)**

```env
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=critical  # Hanya alert penting saja
```

**Akan kirim email untuk:**

-   ✅ Brute force attacks
-   ✅ Successful admin breach attempts
-   ✅ System tampering
-   ❌ Tidak kirim untuk bot biasa atau XSS ringan

### **Level 2: All Security Events**

```env
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=all  # Semua event security
```

**Akan kirim email untuk:**

-   ✅ Semua percobaan attack
-   ✅ Suspicious activities
-   ✅ Bot blocking
-   ⚠️ Bisa banyak email per hari

### **Level 3: Daily Summary Only**

```env
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=summary  # Ringkasan harian saja
```

**Akan kirim:**

-   ✅ 1 email per hari dengan summary
-   ✅ Tidak spam inbox
-   ❌ Tidak real-time alerts

---

## 🔧 **ALTERNATIVE: DISABLE EMAIL ALERTS**

### **Jika Tidak Mau Setup Email:**

```env
# Disable email alerts, hanya log ke file
SECURITY_EMAIL_ALERTS=false
SECURITY_ADMIN_EMAIL=  # Kosongkan

# Monitoring via dashboard saja
# URL: /security-admin/dashboard
```

**✅ Benefit:**

-   Tidak perlu setup email
-   Tetap ada monitoring via web dashboard
-   Semua log tersimpan di file

**❌ Drawback:**

-   Tidak ada notifikasi real-time
-   Harus manual cek dashboard
-   Jika ada attack, tidak langsung tahu

---

## 📱 **INTEGRATION DENGAN MESSAGING (OPTIONAL)**

### **WhatsApp Business API (Advanced)**

```env
# Jika desa punya WhatsApp Business API
SECURITY_WHATSAPP_ALERTS=true
SECURITY_WHATSAPP_NUMBER=628123456789
```

### **Telegram Bot (Free Alternative)**

```env
# Setup Telegram bot (gratis)
SECURITY_TELEGRAM_ALERTS=true
SECURITY_TELEGRAM_CHAT_ID=-1001234567890
SECURITY_TELEGRAM_BOT_TOKEN=your_bot_token
```

---

## 📋 **CHECKLIST SETUP EMAIL ALERTS**

### **Pre-Setup:**

-   [ ] **Tentukan email tujuan** (Gmail pribadi/email desa)
-   [ ] **Pilih email pengirim** (buat Gmail baru/gunakan hosting email)
-   [ ] **Decide alert level** (critical/all/summary)

### **Gmail Setup:**

-   [ ] **Buat Gmail** untuk website desa
-   [ ] **Enable 2FA** di Gmail
-   [ ] **Generate App Password** (16 digit)
-   [ ] **Test login** dengan app password

### **Laravel Configuration:**

-   [ ] **Update .env** dengan SMTP settings
-   [ ] **Set recipient email** di SECURITY_ADMIN_EMAIL
-   [ ] **Test email** dengan: `php artisan tinker` → `Mail::raw('Test', function($m) { $m->to('test@gmail.com'); });`
-   [ ] **Clear config cache**: `php artisan config:clear`

### **Testing:**

-   [ ] **Trigger test alert** (coba login dengan password salah 6 kali)
-   [ ] **Check email received**
-   [ ] **Verify dashboard** di `/security-admin/dashboard`

---

## 🆘 **TROUBLESHOOTING EMAIL**

### **❌ Problem: Email tidak terkirim**

```bash
# Check Laravel logs
tail storage/logs/laravel.log

# Test email connection
php artisan tinker
>>> Mail::raw('Test email', function($message) {
    $message->to('your-email@gmail.com')->subject('Test');
});
```

### **❌ Problem: Gmail App Password tidak work**

1. **Pastikan 2FA enabled** di Gmail
2. **Generate fresh App Password**
3. **Copy exact 16-digit code** (dengan spasi)
4. **Check Gmail "Less secure apps"** (harus OFF untuk App Password)

### **❌ Problem: Email masuk spam**

1. **Add sender** ke contacts: `website.desa.banyukambang@gmail.com`
2. **Mark as not spam** first email
3. **Create Gmail filter** untuk auto-label security emails

---

## 🎯 **REKOMENDASI FINAL**

### **🥇 UNTUK DESA YANG AKTIF MONITORING:**

```env
# Real-time alerts ke multiple recipients
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=critical
SECURITY_ADMIN_EMAIL=kades@gmail.com,sekdes@gmail.com,kaur.umum@gmail.com
```

### **🥈 UNTUK DESA YANG CASUAL:**

```env
# Daily summary saja
SECURITY_EMAIL_ALERTS=true
SECURITY_ALERT_LEVEL=summary
SECURITY_ADMIN_EMAIL=admin.desa@gmail.com
```

### **🥉 UNTUK DESA YANG MINIMAL:**

```env
# Disable email, monitoring manual via dashboard
SECURITY_EMAIL_ALERTS=false
# Check manual: /security-admin/dashboard (weekly)
```

---

## 📞 **SUPPORT & RESOURCES**

### **Email Templates Ready:**

-   ✅ Brute force attack alerts
-   ✅ Suspicious login attempts
-   ✅ Daily/weekly security summaries
-   ✅ System maintenance notifications

### **Dashboard Integration:**

-   ✅ Real-time security monitoring
-   ✅ Email delivery status tracking
-   ✅ Alert configuration management
-   ✅ Recipient management interface

---

**💡 KESIMPULAN**: Gunakan **Gmail pribadi yang sudah ada** untuk kemudahan setup. Tidak perlu buat email khusus baru, kecuali ingin dedicated email untuk website desa.

**Recommended setup: Gmail pribadi Kades/Sekdes + alert level "critical" untuk balance antara informasi penting dan tidak spam inbox! 📧✨**
