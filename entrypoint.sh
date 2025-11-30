#!/bin/bash

# Ini adalah entrypoint untuk Railway, menjalankan skrip persiapan Laravel 
# sebelum kontainer dibiarkan berjalan (stay alive).

echo "--- 🚀 Memulai Skrip Entrypoint Laravel di Railway ---"

# 1. Clear Cache dan Caching Konfigurasi
# Menggunakan '|| true' agar skrip tidak berhenti jika clear cache pertama kali gagal
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan config:cache

# 2. Migrasi Database
# Menjalankan migrasi secara paksa
echo "--- 🛠️ Menjalankan Migrasi Database ---"
php artisan migrate --force

# 3. Storage Link (Penting untuk asset yang diunggah)
# Menggunakan --force untuk memastikan symlink dibuat ulang dan mengatasi error "already exists"
echo "--- 🔗 Menghubungkan Storage Publik ---"
php artisan storage:link --force

# 4. Stay Alive Process
# Karena buildpack Railway tidak selalu memicu web server otomatis
# Kita menggunakan tail -f /dev/null sebagai proses yang tidak pernah berhenti 
# untuk menjaga kontainer tetap hidup (PID 1).
echo "--- 🟢 Menjaga Kontainer Tetap Hidup ---"
exec tail -f /dev/null