#!/bin/sh
set -e
cd /var/www/html

# Render gives the port in $PORT (10000 by default); locally we use 80
PORT="${PORT:-80}"
sed -i "s/^Listen [0-9]\+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/\*:[0-9]\+>/*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    [ -f /data/database.sqlite ] || touch /data/database.sqlite
fi

# Keep one valid APP_KEY across restarts (so sessions survive)
if [ -z "$APP_KEY" ]; then
    if ! grep -Eq '^base64:[A-Za-z0-9+/]{43}=$' /data/app.key 2>/dev/null; then
        php -r 'echo "base64:".base64_encode(random_bytes(32));' > /data/app.key
    fi
    export APP_KEY="$(cat /data/app.key)"
fi

php artisan package:discover --ansi
php artisan migrate --force
php artisan view:cache
chown -R www-data:www-data /data storage bootstrap/cache

exec apache2-foreground 