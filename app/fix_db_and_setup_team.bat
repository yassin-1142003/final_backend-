@echo off
echo Starting database fix and team setup...
echo ======================================

REM Navigate to the project directory
cd %~dp0

REM Clear caches
echo Clearing caches...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

REM Restart the Laravel app
echo Restarting Laravel application...
php artisan down
php artisan up

REM Test the database connection
echo Testing database connection...
php artisan db:monitor

REM Run migrations if needed
echo Running migrations...
php artisan migrate --seed --force

REM Seed team users
echo Creating team user accounts...
php artisan db:seed --class=TeamUsersSeeder --force

REM Clear cache again
echo Final cache clearing...
php artisan config:cache
php artisan route:cache
php artisan optimize

echo Setup completed!
echo Your team now has access with the following accounts:
echo ======================================
echo Admin:    admin@mughtarib.abaadre.com / Admin@123
echo Manager:  manager@mughtarib.abaadre.com / Manager@123
echo User:     user@mughtarib.abaadre.com / User@123
echo Editor:   editor@mughtarib.abaadre.com / Editor@123
echo Support:  support@mughtarib.abaadre.com / Support@123
echo ======================================
echo API is accessible at: https://mughtarib.abaadre.com/public/api

pause 