#!/usr/bin/env bash
set -e

# ---------------------------------------------------------------------------
# Build .env from Railway environment variables
# ---------------------------------------------------------------------------
cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=${APP_URL}

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

SESSION_DRIVER=database
SESSION_LIFETIME=120

QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=local

MAIL_MAILER=${MAIL_MAILER:-log}
MAIL_HOST=${MAIL_HOST:-127.0.0.1}
MAIL_PORT=${MAIL_PORT:-2525}
MAIL_USERNAME=${MAIL_USERNAME:-null}
MAIL_PASSWORD=${MAIL_PASSWORD:-null}
MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS:-hello@example.com}
MAIL_FROM_NAME="\${APP_NAME}"
EOF

# ---------------------------------------------------------------------------
# Laravel bootstrap
# ---------------------------------------------------------------------------
php artisan storage:link --force || true
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan package:discover --ansi
php artisan migrate --force

# ---------------------------------------------------------------------------
# Start PHP-FPM on port 9000
# ---------------------------------------------------------------------------
php-fpm -D -y /etc/php-fpm.conf 2>/dev/null || \
  php-fpm8.3 -D 2>/dev/null || \
  php-fpm8.2 -D 2>/dev/null || \
  php-fpm -D 2>&1 || true

# Give PHP-FPM a moment to start
sleep 1

# ---------------------------------------------------------------------------
# Render nginx config with the correct PORT (default 8000)
# ---------------------------------------------------------------------------
export PORT="${PORT:-8000}"

mkdir -p /tmp/nginx_client_body /tmp/nginx_proxy /tmp/nginx_fastcgi \
         /tmp/nginx_uwsgi /tmp/nginx_scgi /var/log/nginx /var/cache/nginx

# Substitute $PORT in nginx.conf and write to a writable location
envsubst '${PORT}' < /app/nginx.conf > /tmp/nginx.conf

# ---------------------------------------------------------------------------
# Start Nginx in the foreground
# ---------------------------------------------------------------------------
exec nginx -c /tmp/nginx.conf -g "daemon off;"
