#!/bin/bash

# Real Estate API Deployment Script
# For server: https://mughtarib.abaadre.com/public/api

echo "Starting deployment process..."
echo "======================================"

# Navigate to the project directory
cd $(dirname "$0")

# Clear caches
echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize the application
echo "Optimizing the application..."
php artisan optimize

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed the database if needed
# Uncomment the line below to seed the database
# echo "Seeding the database..."
# php artisan db:seed --force

# Create storage link if it doesn't exist
echo "Creating storage link..."
php artisan storage:link

# Set proper permissions
echo "Setting permissions..."
chmod -R 755 storage bootstrap/cache

# Serve the application
echo "Deployment completed!"
echo "The application is now deployed and ready to use."
echo "API is accessible at: https://mughtarib.abaadre.com/public/api" 