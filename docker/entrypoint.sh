#!/bin/sh

set -eu

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --ansi
fi

database_path="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
database_directory=$(dirname "$database_path")
mkdir -p "$database_directory"

if [ ! -f "$database_path" ]; then
    touch "$database_path"
fi

php artisan package:discover --ansi
php artisan migrate --force

seed_marker="$database_directory/.seeded"
if [ ! -f "$seed_marker" ]; then
    php artisan db:seed --force
    touch "$seed_marker"
fi

exec php artisan serve --host=0.0.0.0 --port=8000
