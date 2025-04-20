#!/bin/bash

# Fix Database Connection and Team Access Setup
# For server: https://mughtarib.abaadre.com/public/api

echo "Starting database fix and team setup..."
echo "======================================"

# Navigate to the project directory
cd $(dirname "$0")

# Clear caches
echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Restart the Laravel app
echo "Restarting Laravel application..."
php artisan down
php artisan up

# Test the database connection
echo "Testing database connection..."
php artisan db:monitor

# Run migrations if needed
echo "Running migrations..."
php artisan migrate --seed --force

# Seed team users
echo "Creating team user accounts..."
php artisan db:seed --class=TeamUsersSeeder --force

# Clear cache again
echo "Final cache clearing..."
php artisan config:cache
php artisan route:cache
php artisan optimize

echo "Setup completed!"
echo "Your team now has access with the following accounts:"
echo "======================================"
echo "Admin:    admin@mughtarib.abaadre.com / Admin@123"
echo "Manager:  manager@mughtarib.abaadre.com / Manager@123"
echo "User:     user@mughtarib.abaadre.com / User@123"
echo "Editor:   editor@mughtarib.abaadre.com / Editor@123"
echo "Support:  support@mughtarib.abaadre.com / Support@123"
echo "======================================"
echo "API is accessible at: https://mughtarib.abaadre.com/public/api" 