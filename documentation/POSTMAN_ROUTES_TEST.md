# POSTMAN TEST ROUTES - INFOGRAFIS
# Base URL: http://127.0.0.1:8000

## 1. HALAMAN UTAMA INFOGRAFIS
GET http://127.0.0.1:8000/infografis
GET http://127.0.0.1:8000/infografis?tahun=2024
GET http://127.0.0.1:8000/infografis?tahun=2023
GET http://127.0.0.1:8000/infografis?tahun=2022

## 2. API ENDPOINTS - MAIN
GET http://127.0.0.1:8000/api/infografis
GET http://127.0.0.1:8000/api/infografis?tahun=2024
GET http://127.0.0.1:8000/api/infografis?tahun=2023

## 3. API ENDPOINTS - SPECIFIC SECTIONS
GET http://127.0.0.1:8000/api/infografis/statistik
GET http://127.0.0.1:8000/api/infografis/statistik?tahun=2024
GET http://127.0.0.1:8000/api/infografis/statistik?tahun=2023

GET http://127.0.0.1:8000/api/infografis/umur
GET http://127.0.0.1:8000/api/infografis/umur?tahun=2024
GET http://127.0.0.1:8000/api/infografis/umur?tahun=2023

GET http://127.0.0.1:8000/api/infografis/pendidikan
GET http://127.0.0.1:8000/api/infografis/pendidikan?tahun=2024
GET http://127.0.0.1:8000/api/infografis/pendidikan?tahun=2023

GET http://127.0.0.1:8000/api/infografis/pekerjaan
GET http://127.0.0.1:8000/api/infografis/pekerjaan?tahun=2024
GET http://127.0.0.1:8000/api/infografis/pekerjaan?tahun=2023

GET http://127.0.0.1:8000/api/infografis/agama
GET http://127.0.0.1:8000/api/infografis/agama?tahun=2024
GET http://127.0.0.1:8000/api/infografis/agama?tahun=2023

GET http://127.0.0.1:8000/api/infografis/perkawinan
GET http://127.0.0.1:8000/api/infografis/perkawinan?tahun=2024
GET http://127.0.0.1:8000/api/infografis/perkawinan?tahun=2023

GET http://127.0.0.1:8000/api/infografis/wajib-pilih
GET http://127.0.0.1:8000/api/infografis/wajib-pilih?tahun=2024
GET http://127.0.0.1:8000/api/infografis/wajib-pilih?tahun=2023

GET http://127.0.0.1:8000/api/infografis/dusun
GET http://127.0.0.1:8000/api/infografis/dusun?tahun=2024
GET http://127.0.0.1:8000/api/infografis/dusun?tahun=2023

## 4. API ENDPOINTS - CHART DATA
GET http://127.0.0.1:8000/api/infografis/statistik/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/umur/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/pendidikan/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/pekerjaan/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/agama/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/perkawinan/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/wajib-pilih/chart?tahun=2024
GET http://127.0.0.1:8000/api/infografis/dusun/chart?tahun=2024

## 5. API ENDPOINTS - ANALISIS
GET http://127.0.0.1:8000/api/infografis/statistik/analisis?tahun=2024
GET http://127.0.0.1:8000/api/infografis/umur/analisis?tahun=2024
GET http://127.0.0.1:8000/api/infografis/pendidikan/analisis?tahun=2024

## 6. TEST DENGAN TAHUN BERBEDA (cek mana yang ada datanya)
GET http://127.0.0.1:8000/api/infografis/pekerjaan?tahun=2025  # Harusnya error/dummy
GET http://127.0.0.1:8000/api/infografis/pekerjaan?tahun=2024  # Harusnya ada data
GET http://127.0.0.1:8000/api/infografis/pekerjaan?tahun=2023  # Harusnya ada data

GET http://127.0.0.1:8000/api/infografis/perkawinan?tahun=2025  # Harusnya error/dummy
GET http://127.0.0.1:8000/api/infografis/perkawinan?tahun=2024  # Harusnya ada data
GET http://127.0.0.1:8000/api/infografis/perkawinan?tahun=2023  # Harusnya ada data

## PRIORITY TESTS (test ini dulu):
1. GET http://127.0.0.1:8000/infografis?tahun=2024
2. GET http://127.0.0.1:8000/api/infografis/pekerjaan?tahun=2024
3. GET http://127.0.0.1:8000/api/infografis/perkawinan?tahun=2024
4. GET http://127.0.0.1:8000/api/infografis/umur?tahun=2024