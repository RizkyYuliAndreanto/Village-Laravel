#!/bin/bash

# 1. Jalankan semua perintah persiapan
php artisan config:clear
php artisan config:cache
php artisan migrate --force
php artisan storage:link

# 2. Cari proses utama web server yang dibutuhkan oleh buildpack Railway (biasanya Nginx atau Apache)
# Perintah ini akan menggantikan proses shell saat ini dengan proses utama web server,
# yang akan menjaga kontainer tetap hidup.

# Coba jalankan perintah start default dari buildpack PHP/Nginx/Apache
/usr/bin/supervisord -n -c /etc/supervisor/conf.d/php-fpm.conf & 
/usr/sbin/nginx -g 'daemon off;'