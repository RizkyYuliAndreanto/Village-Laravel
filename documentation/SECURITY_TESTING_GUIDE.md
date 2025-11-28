# Security System Testing Guide

## Menguji Sistem Keamanan Village Web

### 1. Artisan Commands untuk Security

```bash
# Monitor keamanan
php artisan security:monitor

# Clear security cache
php artisan security:monitor --clear-cache

# Cleanup old logs
php artisan security:cleanup --days=30
```

### 2. Testing XSS Protection

```bash
# Test XSS via curl (akan diblokir)
curl -X POST http://localhost:8000/api/test \
  -d "name=<script>alert('xss')</script>" \
  -d "message=Hello <img src=x onerror=alert(1)>"
```

### 3. Testing SQL Injection Protection

```bash
# Test SQL injection (akan diblokir)
curl -X GET "http://localhost:8000/api/users?id=1' OR '1'='1"
curl -X POST http://localhost:8000/api/login \
  -d "email=admin@test.com' OR '1'='1" \
  -d "password=password"
```

### 4. Testing Rate Limiting

```bash
# Test rate limiting (kirim banyak request)
for i in {1..70}; do
  curl -X GET http://localhost:8000/api/test
  echo "Request $i"
done
```

### 5. Testing Brute Force Protection

```bash
# Test brute force login
for i in {1..15}; do
  curl -X POST http://localhost:8000/login \
    -d "email=admin@test.com" \
    -d "password=wrongpassword$i"
  echo "Login attempt $i"
done
```

### 6. Monitoring Log Files

```bash
# View security logs
tail -f storage/logs/security.log
tail -f storage/logs/xss.log
tail -f storage/logs/sql-injection.log
tail -f storage/logs/brute-force.log
tail -f storage/logs/ddos.log
```

### 7. Environment Variables (.env)

Tambahkan ke file .env:

```env
# Security Configuration
SECURITY_EMAIL_ALERTS=false
SECURITY_ADMIN_EMAIL=admin@yourdomain.com
SECURITY_SLACK_WEBHOOK=

# Rate Limiting
SECURITY_RATE_LIMIT=60
SECURITY_RATE_WINDOW=1

# Auto-ban Configuration
SECURITY_AUTO_BAN_ENABLED=true
```

### 8. Monitoring Security Stats

```php
// Dalam controller atau route
use App\Services\SecurityService;

Route::get('/security-stats', function (SecurityService $security) {
    return response()->json($security->getSecurityStats());
});
```

### 9. Manual IP Management

```php
// Block IP manually
$security = app(SecurityService::class);
$security->blacklistIP('192.168.1.100', 60); // Block for 60 minutes

// Check if IP is blocked
if ($security->isBlacklisted('192.168.1.100')) {
    // IP is blocked
}

// Remove from blacklist
$security->removeFromBlacklist('192.168.1.100');
```

### 10. Security Headers Testing

Test security headers menggunakan online tools:

-   https://securityheaders.com/
-   https://observatory.mozilla.org/

### 11. File Upload Security Testing

```bash
# Test malicious file upload
curl -X POST http://localhost:8000/upload \
  -F "file=@malicious.php" \
  -F "type=image"
```

### 12. Scheduled Tasks (Cron)

Tambahkan ke crontab untuk automated cleanup:

```bash
# Edit crontab
crontab -e

# Add these lines:
0 2 * * * cd /path/to/your/project && php artisan security:cleanup --days=30
0 * * * * cd /path/to/your/project && php artisan security:monitor
```

### 13. Database Indexes untuk Performance

Jika menggunakan database untuk logging:

```sql
-- Untuk tabel security_logs
CREATE INDEX idx_security_ip ON security_logs(ip_address);
CREATE INDEX idx_security_type ON security_logs(event_type);
CREATE INDEX idx_security_timestamp ON security_logs(created_at);
```

### 14. Nginx Configuration

Tambahkan ke nginx config untuk extra protection:

```nginx
# Rate limiting
limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
limit_req_zone $binary_remote_addr zone=api:10m rate=30r/m;

server {
    # Apply rate limiting
    location /login {
        limit_req zone=login burst=3 nodelay;
    }

    location /api/ {
        limit_req zone=api burst=10 nodelay;
    }

    # Security headers (backup)
    add_header X-Frame-Options DENY;
    add_header X-Content-Type-Options nosniff;
    add_header X-XSS-Protection "1; mode=block";
}
```

### 15. Alerts dan Notifications

Setup untuk mendapat notifikasi saat ada serangan:

```php
// Dalam .env
SECURITY_EMAIL_ALERTS=true
SECURITY_ADMIN_EMAIL=security@yourdomain.com

// Atau setup Slack webhook
SECURITY_SLACK_WEBHOOK=https://hooks.slack.com/services/...
```

## Tips Keamanan Tambahan

1. **Regular Updates**: Selalu update Laravel dan dependencies
2. **Backup Database**: Backup database secara rutin
3. **Monitor Logs**: Review security logs secara berkala
4. **Network Security**: Gunakan firewall dan VPN
5. **SSL Certificate**: Pastikan menggunakan HTTPS
6. **Server Hardening**: Harden server configuration

## Performance Considerations

1. **Cache Cleanup**: Regular cleanup cache security
2. **Log Rotation**: Setup log rotation untuk mencegah disk penuh
3. **Database Indexing**: Index tabel security logs
4. **Redis/Memcached**: Gunakan untuk session dan cache

## Emergency Response

Jika terjadi serangan:

1. Block IP secara manual
2. Enable maintenance mode: `php artisan down`
3. Check dan analyze logs
4. Update security rules
5. Notify team dan stakeholders
