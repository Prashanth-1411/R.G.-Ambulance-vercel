#!/bin/bash
set -e

cd /var/www/html

# Create .env from template if missing
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Always apply environment variable overrides
for var in APP_NAME APP_ENV APP_DEBUG APP_URL DB_CONNECTION DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD SESSION_DRIVER CACHE_STORE QUEUE_CONNECTION LOG_CHANNEL; do
    val="${!var}"
    [ -z "$val" ] && continue
    [ "$var" = "APP_KEY" ] && continue
    case "$val" in *\ *) val="\"$val\"" ;; esac
    sed -i "s|^# *$var=.*|$var=$val|; s|^$var=.*|$var=$val|" .env
done

# Unset APP_KEY from env so Laravel uses the .env value
unset APP_KEY

# Generate APP_KEY if not already set
if ! grep -q "APP_KEY=base64" .env 2>/dev/null; then
    php artisan key:generate --force
fi

# Clear stale cache
rm -rf bootstrap/cache/*.php

# Wait for database and run migrations
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database connection..."
    for i in $(seq 1 15); do
        php artisan db:show --quiet 2>&1 && break
        echo "Attempt $i/15 — database not ready, retrying in 3s..."
        sleep 3
    done
    echo "Running migrations..."
    php artisan migrate --force
    if [ ! -f /var/www/html/storage/.seeded ]; then
        echo "Seeding database (first run only)..."
        php artisan db:seed --force && touch /var/www/html/storage/.seeded || true
    fi
fi

# Storage link
php artisan storage:link --force 2>/dev/null || true

# Cache for production
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

exec "$@"
