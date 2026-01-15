#!/bin/sh

set -e

# Optionally run migrations & seeders if environent variable is true
if [ "$RUN_DB_MIGRATIONS" = "true" ]; then
    echo "Running database migrations and seeders..."
    php artisan migrate --force
    php artisan db:seed --force
else
    echo "Skipping DB migrations and seeders"
fi

# Clear cached config 
rm -f bootstrap/cache/config.php

echo "Starting Apache in foreground..."
apache2-foreground