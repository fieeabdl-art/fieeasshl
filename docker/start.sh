#!/bin/sh

set -e

PORT="${PORT:-10000}"

sed -i "s/^Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan storage:link --force || true

# Jalankan migration otomatis tiap container start.
# Diperlukan karena Render free tier tidak punya akses tab "Shell".
# Aman dijalankan berulang kali karena Laravel skip migration yang sudah pernah jalan.
php artisan migrate --force || true

exec apache2-foreground
