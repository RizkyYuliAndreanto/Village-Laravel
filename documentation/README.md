# Village Web API Documentation

Dokumentasi lengkap untuk API aplikasi web desa yang menyediakan layanan statistik penduduk dan manajemen data administratif.

## 📁 Struktur Dokumentasi

```
documentation/
├── api-documentation.md    # Dokumentasi lengkap API endpoints
├── todo-list.md           # Daftar tugas pengembangan API
└── README.md             # File ini - panduan navigasi dokumentasi
```

## 🚀 Quick Start

### 1. Base URL

```
Production: https://your-domain.com/api
Development: http://127.0.0.1:8000/api
```

### 2. Authentication

API menggunakan JWT (JSON Web Token). Untuk endpoint yang memerlukan authentication:

```bash
# Login untuk mendapatkan token
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Gunakan token untuk request selanjutnya
curl -X GET http://127.0.0.1:8000/api/v1/admin/tahun-data \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 3. Response Format

Semua response menggunakan format JSON standar:

```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        /* response data */
    }
}
```

## 📖 Dokumentasi Lengkap

### [📄 API Documentation](./api-documentation.md)

Dokumentasi lengkap semua endpoint API termasuk:

-   Authentication endpoints
-   Public API endpoints (statistik)
-   Protected admin endpoints
-   Request/response examples
-   Error handling
-   HTTP status codes

### [✅ Todo List](./todo-list.md)

Daftar pengembangan API yang mencakup:

-   ✅ Fitur yang sudah selesai
-   🚨 Prioritas tinggi
-   📋 Prioritas menengah
-   🔮 Pengembangan masa depan
-   🐛 Bug yang perlu diperbaiki

## 🎯 API Endpoints Summary

### Authentication

-   `POST /v1/auth/login` - Login
-   `POST /v1/auth/refresh` - Refresh token
-   `POST /v1/auth/logout` - Logout
-   `GET /v1/auth/profile` - Get profile

### Public Statistics

-   `GET /v1/tahun-data` - Get years data
-   `GET /v1/demografi-penduduk` - Get demographics
-   `GET /v1/umur-statistik` - Get age statistics
-   `GET /v1/demografi-penduduk-summary` - Population summary

### Admin Management (Requires Auth)

-   `POST/PUT/DELETE /v1/admin/tahun-data` - Manage years
-   `POST/PUT/DELETE /v1/admin/demografi-penduduk` - Manage demographics
-   `POST/PUT/DELETE /v1/admin/umur-statistik` - Manage age stats

## 🛠️ Development Status

### ✅ Implemented

-   JWT Authentication system
-   Tahun Data CRUD operations
-   Demografi Penduduk CRUD operations
-   Umur Statistik CRUD operations
-   Basic API structure

### 🚧 In Progress

-   Input validation & security
-   Error handling standardization
-   Additional statistical endpoints

### 📅 Planned

-   Advanced filtering & search
-   Data export (Excel, PDF, CSV)
-   API monitoring & analytics
-   Comprehensive testing suite

## 🔧 Technical Information

### Requirements

-   Laravel 10+
-   PHP 8.1+
-   JWT Authentication
-   MySQL Database

### Middleware

-   `jwt.auth` - JWT authentication
-   `api` - API rate limiting & throttling

### Response Headers

```
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
```

## 📝 Usage Examples

### JavaScript/Fetch

```javascript
// Get population summary
fetch("http://127.0.0.1:8000/api/v1/demografi-penduduk-summary")
    .then((response) => response.json())
    .then((data) => console.log(data));

// Create new year data (with auth)
fetch("http://127.0.0.1:8000/api/v1/admin/tahun-data", {
    method: "POST",
    headers: {
        Authorization: "Bearer " + token,
        "Content-Type": "application/json",
    },
    body: JSON.stringify({
        tahun: 2024,
        keterangan: "Data tahun 2024",
    }),
});
```

### PHP/Laravel

```php
// Using Guzzle HTTP client
$client = new \GuzzleHttp\Client();

$response = $client->post('http://127.0.0.1:8000/api/v1/auth/login', [
    'json' => [
        'email' => 'admin@example.com',
        'password' => 'password'
    ]
]);

$data = json_decode($response->getBody(), true);
$token = $data['data']['access_token'];
```

## 🔍 Testing

### Manual Testing

Gunakan tools seperti:

-   **Postman** - GUI testing
-   **cURL** - Command line testing
-   **Insomnia** - Alternative GUI

### Automated Testing

```bash
# Run API tests
php artisan test --testsuite=Feature

# Test specific endpoint
php artisan test tests/Feature/Api/AuthTest.php
```

## 📊 Rate Limiting

-   **Public endpoints**: 60 requests per minute
-   **Authenticated endpoints**: 120 requests per minute
-   **Admin endpoints**: 200 requests per minute

## ⚠️ Common Issues

### 1. CORS Issues

Pastikan konfigurasi CORS sudah benar di `config/cors.php`

### 2. JWT Token Expired

Token memiliki masa berlaku 1 jam. Gunakan refresh endpoint untuk perpanjang.

### 3. Route Not Found

Pastikan menggunakan `/api` prefix untuk semua API calls.

## 🆘 Support

### Bug Reports

-   Create issue di repository GitHub
-   Include request/response examples
-   Provide error logs

### Feature Requests

-   Check todo-list.md untuk planned features
-   Submit detailed feature description
-   Include use case examples

## 📜 License

This API documentation is part of Village Web Application project.

---

**Last Updated:** November 11, 2025  
**API Version:** v1  
**Laravel Version:** 10.x
