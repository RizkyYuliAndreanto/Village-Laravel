# API Documentation - Village Web Application

## Overview

API Documentation untuk aplikasi web desa yang menyediakan data statistik penduduk, demografi, dan manajemen data administratif.

**Base URL:** `http://127.0.0.1:8000/api`
**Version:** v1

## Authentication

API menggunakan JWT (JSON Web Token) untuk authentication pada endpoint yang memerlukan otorisasi.

### Headers yang diperlukan:

```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {jwt_token} (untuk endpoint yang memerlukan auth)
```

---

## Public API Endpoints

### 1. Authentication

#### 1.1 Login

**POST** `/v1/auth/login`

Endpoint untuk login dan mendapatkan JWT token.

**Request Body:**

```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

**Response Success (200):**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@example.com"
        },
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

#### 1.2 Refresh Token

**POST** `/v1/auth/refresh`

Endpoint untuk refresh JWT token yang akan expire.

**Response Success (200):**

```json
{
    "success": true,
    "message": "Token refreshed successfully",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

### 2. Tahun Data (Year Data)

#### 2.1 Get All Years

**GET** `/v1/tahun-data`

Mendapatkan daftar semua tahun data yang tersedia.

**Response Success (200):**

```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": [
        {
            "id": 1,
            "tahun": 2023,
            "keterangan": "Data tahun 2023",
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### 2.2 Get Specific Year

**GET** `/v1/tahun-data/{tahunId}`

Mendapatkan detail data tahun tertentu.

**Parameters:**

-   `tahunId` (integer, required) - ID tahun data

**Response Success (200):**

```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": {
        "id": 1,
        "tahun": 2023,
        "keterangan": "Data tahun 2023",
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

#### 2.3 Get Years List

**GET** `/v1/tahun-data-list`

Mendapatkan daftar tahun dalam format sederhana untuk dropdown/select.

**Response Success (200):**

```json
{
    "success": true,
    "message": "Years list retrieved successfully",
    "data": [
        {
            "id": 1,
            "tahun": 2023
        },
        {
            "id": 2,
            "tahun": 2024
        }
    ]
}
```

### 3. Demografi Penduduk (Population Demographics)

#### 3.1 Get All Demographics Data

**GET** `/v1/demografi-penduduk`

**Query Parameters:**

-   `tahun_id` (integer, optional) - Filter by year ID
-   `per_page` (integer, optional, default: 15) - Items per page
-   `page` (integer, optional, default: 1) - Page number

**Response Success (200):**

```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "tahun_id": 1,
                "jumlah_penduduk": 5000,
                "laki_laki": 2500,
                "perempuan": 2500,
                "kepala_keluarga": 1250,
                "created_at": "2025-01-01T00:00:00.000000Z",
                "updated_at": "2025-01-01T00:00:00.000000Z",
                "tahun_data": {
                    "id": 1,
                    "tahun": 2023
                }
            }
        ],
        "per_page": 15,
        "total": 1
    }
}
```

#### 3.2 Get Specific Demographics

**GET** `/v1/demografi-penduduk/{demografiId}`

**Parameters:**

-   `demografiId` (integer, required) - ID demografi penduduk

#### 3.3 Get Demographics by Year

**GET** `/v1/demografi-penduduk/tahun/{tahunId}`

**Parameters:**

-   `tahunId` (integer, required) - ID tahun data

#### 3.4 Get Population Summary

**GET** `/v1/demografi-penduduk-summary`

Mendapatkan ringkasan data populasi.

**Response Success (200):**

```json
{
    "success": true,
    "message": "Population summary retrieved successfully",
    "data": {
        "total_population": 5000,
        "male_population": 2500,
        "female_population": 2500,
        "total_families": 1250,
        "latest_year": 2023
    }
}
```

### 4. Umur Statistik (Age Statistics)

#### 4.1 Get All Age Statistics

**GET** `/v1/umur-statistik`

**Query Parameters:**

-   `tahun_id` (integer, optional) - Filter by year ID
-   `per_page` (integer, optional, default: 15) - Items per page

#### 4.2 Get Specific Age Statistics

**GET** `/v1/umur-statistik/{umurStatistikId}`

#### 4.3 Get Age Statistics by Year

**GET** `/v1/umur-statistik/tahun/{tahunId}`

#### 4.4 Get Age Distribution

**GET** `/v1/umur-statistik-distribusi`

Mendapatkan distribusi usia penduduk.

**Response Success (200):**

```json
{
    "success": true,
    "message": "Age distribution retrieved successfully",
    "data": {
        "age_groups": [
            {
                "range": "0-14",
                "count": 1000,
                "percentage": 20
            },
            {
                "range": "15-64",
                "count": 3500,
                "percentage": 70
            },
            {
                "range": "65+",
                "count": 500,
                "percentage": 10
            }
        ]
    }
}
```

#### 4.5 Get Productive Age Summary

**GET** `/v1/umur-statistik-produktif`

Mendapatkan ringkasan usia produktif (15-64 tahun).

---

## Protected API Endpoints (Requires Authentication)

### 1. Authentication (Protected)

#### 1.1 Logout

**POST** `/v1/auth/logout`

**Headers:** `Authorization: Bearer {token}`

#### 1.2 Logout All Sessions

**POST** `/v1/auth/logout-all`

**Headers:** `Authorization: Bearer {token}`

#### 1.3 Get User Profile

**GET** `/v1/auth/profile`

**Headers:** `Authorization: Bearer {token}`

#### 1.4 Change Password

**POST** `/v1/auth/change-password`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "current_password": "oldpassword",
    "new_password": "newpassword",
    "new_password_confirmation": "newpassword"
}
```

### 2. Admin Management Endpoints

Base path: `/v1/admin` (Requires JWT Authentication)

#### 2.1 Tahun Data Management

##### Create Year Data

**POST** `/v1/admin/tahun-data`

**Request Body:**

```json
{
    "tahun": 2024,
    "keterangan": "Data tahun 2024"
}
```

##### Update Year Data

**PUT** `/v1/admin/tahun-data/{tahunId}`

**Request Body:**

```json
{
    "tahun": 2024,
    "keterangan": "Data tahun 2024 (updated)"
}
```

##### Delete Year Data

**DELETE** `/v1/admin/tahun-data/{tahunId}`

#### 2.2 Demografi Penduduk Management

##### Create Demographics Data

**POST** `/v1/admin/demografi-penduduk`

**Request Body:**

```json
{
    "tahun_id": 1,
    "jumlah_penduduk": 5500,
    "laki_laki": 2750,
    "perempuan": 2750,
    "kepala_keluarga": 1375
}
```

##### Update Demographics Data

**PUT** `/v1/admin/demografi-penduduk/{demografiId}`

##### Delete Demographics Data

**DELETE** `/v1/admin/demografi-penduduk/{demografiId}`

#### 2.3 Umur Statistik Management

##### Create Age Statistics

**POST** `/v1/admin/umur-statistik`

**Request Body:**

```json
{
    "tahun_id": 1,
    "umur_0_14": 1000,
    "umur_15_64": 3500,
    "umur_65_plus": 500
}
```

##### Update Age Statistics

**PUT** `/v1/admin/umur-statistik/{umurStatistikId}`

##### Delete Age Statistics

**DELETE** `/v1/admin/umur-statistik/{umurStatistikId}`

---

## Response Format

### Success Response

```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // Response data
    }
}
```

### Error Response

```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

## HTTP Status Codes

-   `200` - OK (Success)
-   `201` - Created (Resource created successfully)
-   `400` - Bad Request (Invalid request data)
-   `401` - Unauthorized (Invalid or missing authentication)
-   `403` - Forbidden (Access denied)
-   `404` - Not Found (Resource not found)
-   `422` - Unprocessable Entity (Validation errors)
-   `500` - Internal Server Error

## Rate Limiting

API memiliki rate limiting untuk mencegah abuse:

-   Public endpoints: 60 requests per minute
-   Authenticated endpoints: 120 requests per minute

## Pagination

Untuk endpoint yang mengembalikan list data, respons menggunakan pagination:

```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [...],
        "first_page_url": "http://localhost/api/v1/endpoint?page=1",
        "from": 1,
        "last_page": 5,
        "last_page_url": "http://localhost/api/v1/endpoint?page=5",
        "links": [...],
        "next_page_url": "http://localhost/api/v1/endpoint?page=2",
        "path": "http://localhost/api/v1/endpoint",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 75
    }
}
```

## Examples

### JavaScript/Fetch Example

```javascript
// Login
const login = async () => {
    const response = await fetch("http://127.0.0.1:8000/api/v1/auth/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({
            email: "admin@example.com",
            password: "password",
        }),
    });

    const data = await response.json();
    if (data.success) {
        localStorage.setItem("token", data.data.access_token);
    }
};

// Get demographics data with authentication
const getDemographics = async () => {
    const token = localStorage.getItem("token");
    const response = await fetch(
        "http://127.0.0.1:8000/api/v1/demografi-penduduk",
        {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        }
    );

    return await response.json();
};
```

### cURL Examples

```bash
# Login
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get demographics data
curl -X GET http://127.0.0.1:8000/api/v1/demografi-penduduk \
  -H "Accept: application/json"

# Create new year data (authenticated)
curl -X POST http://127.0.0.1:8000/api/v1/admin/tahun-data \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{"tahun":2024,"keterangan":"Data tahun 2024"}'
```
