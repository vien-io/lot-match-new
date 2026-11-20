
#!/bin/sh

set -e

# Optionally run migrations & all seeders if environment variable is true
if [ "$RUN_DB_MIGRATIONS" = "true" ]; then
    echo "Running fresh migrations and all database seeders..."

    php artisan migrate:fresh --seed --force

    echo "Database migrations and seeders completed!"
else
    echo "Skipping DB migrations and seeders"
fi

# Clear cached config
rm -f bootstrap/cache/config.php

# Recreate public storage symlink
echo "Creating storage symlink..."

if [ -L public/storage ]; then
    rm public/storage
fi

php artisan storage:link --force

echo "Storage symlink created!"

echo "Starting Laravel queue worker in background..."
php artisan queue:work --sleep=3 --tries=3 &

echo "Starting Apache in foreground..."
apache2-foreground
