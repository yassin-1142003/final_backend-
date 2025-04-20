<?php
/**
 * Database Migration Test Script
 * 
 * This script tests the database connection and runs migrations
 * for the new server at https://mughtarib.abaadre.com
 */

// Load environment variables
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// Extract database credentials from environment
$host = getenv('DB_HOST') ?: 'mughtarib.abaadre.com';
$port = getenv('DB_PORT') ?: '3306';
$database = getenv('DB_DATABASE') ?: 'mughtarib_realestate';
$username = getenv('DB_USERNAME') ?: 'mughtarib_admin';
$password = getenv('DB_PASSWORD') ?: 'Yassin_1142003';

echo "Database Connection Test\n";
echo "======================================\n\n";
echo "Host: $host\n";
echo "Database: $database\n";
echo "Username: $username\n";
echo "Port: $port\n\n";

// Test database connection
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Database connection successful!\n\n";
    
    // Check if migrations table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
    $migrationTableExists = $stmt->rowCount() > 0;
    
    if ($migrationTableExists) {
        echo "Migrations table exists. Checking migration status...\n";
        
        // Get the list of migrations that have been run
        $stmt = $pdo->query("SELECT * FROM migrations ORDER BY batch DESC, id DESC LIMIT 5");
        $migrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($migrations) > 0) {
            echo "Last 5 migrations:\n";
            foreach ($migrations as $migration) {
                echo "- {$migration['migration']} (Batch: {$migration['batch']})\n";
            }
        } else {
            echo "No migrations have been run yet.\n";
        }
    } else {
        echo "Migrations table does not exist. Database might not be initialized.\n";
        echo "Please run 'php artisan migrate' to set up the database schema.\n";
    }
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "\nUsers table exists. Checking user count...\n";
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "Total users: $count\n";
    } else {
        echo "\nUsers table does not exist.\n";
    }
    
    // Check if roles table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'roles'");
    if ($stmt->rowCount() > 0) {
        echo "\nRoles table exists. Checking roles...\n";
        $stmt = $pdo->query("SELECT id, name FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($roles) > 0) {
            echo "Available roles:\n";
            foreach ($roles as $role) {
                echo "- {$role['id']}: {$role['name']}\n";
            }
        } else {
            echo "No roles defined yet.\n";
        }
    } else {
        echo "\nRoles table does not exist.\n";
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    echo "\nPlease check your database credentials and ensure the database server is accessible.\n";
}

echo "\nTest completed.\n";
echo "To run migrations, use 'php artisan migrate' command.\n";
echo "To seed the database, use 'php artisan db:seed' command.\n"; 