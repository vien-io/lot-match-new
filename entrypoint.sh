#!/bin/sh

set -e

# Optionally run migrations & seeders if environment variable is true
if [ "$RUN_DB_MIGRATIONS" = "true" ]; then
    echo "Running database migrations and seeders..."
    php artisan migrate:fresh --force

    echo "Seeding BlocksTableSeeder..."
    php artisan db:seed --class=BlocksTableSeeder --force
    echo "BlocksTableSeeder finished!"

    echo "Seeding LotSeeder..."
    php artisan db:seed --class=LotSeeder --force
    echo "LotSeeder finished!"

    echo "Seeding UserTableSeeder..."
    php artisan db:seed --class=UserTableSeeder --force
    echo "UserTableSeeder finished!"

    echo "Seeding ReviewsTableSeeder..."
    php artisan db:seed --class=ReviewsTableSeeder --force
    echo "ReviewsTableSeeder finished!"

    echo "Seeding UpdateSoldLotsSeeder..."
    php artisan db:seed --class=UpdateSoldLotsSeeder --force
    echo "UpdateSoldLotsSeeder finished!"
    
else
    echo "Skipping DB migrations and seeders"
fi

# Clear cached config 
rm -f bootstrap/cache/config.php

echo "Starting Laravel queue worker in background..."
php artisan queue:work --sleep=3 --tries=3 &

echo "Starting Apache in foreground..."
apache2-foreground