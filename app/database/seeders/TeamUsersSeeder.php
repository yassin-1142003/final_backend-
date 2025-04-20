<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class TeamUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create team members with different roles
        
        // 1. Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mughtarib.abaadre.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 1, // Admin role
            'phone' => '1234567890',
            'email_verified_at' => now(),
        ]);
        
        // 2. Property Owner
        User::create([
            'name' => 'Property Manager',
            'email' => 'manager@mughtarib.abaadre.com',
            'password' => Hash::make('Manager@123'),
            'role_id' => 2, // Property Owner role
            'phone' => '2345678901',
            'email_verified_at' => now(),
        ]);
        
        // 3. Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@mughtarib.abaadre.com',
            'password' => Hash::make('User@123'),
            'role_id' => 3, // Regular User role
            'phone' => '3456789012',
            'email_verified_at' => now(),
        ]);
        
        // 4. Content Editor
        User::create([
            'name' => 'Content Editor',
            'email' => 'editor@mughtarib.abaadre.com',
            'password' => Hash::make('Editor@123'),
            'role_id' => 2, // Using property owner role with editor privileges
            'phone' => '4567890123',
            'email_verified_at' => now(),
        ]);
        
        // 5. Support Staff
        User::create([
            'name' => 'Support Staff',
            'email' => 'support@mughtarib.abaadre.com',
            'password' => Hash::make('Support@123'),
            'role_id' => 2, // Using property owner role with limited access
            'phone' => '5678901234',
            'email_verified_at' => now(),
        ]);
        
        // Output the created users
        $this->command->info('Team member accounts created successfully!');
        $this->command->table(
            ['Name', 'Email', 'Role', 'Password'],
            [
                ['Admin User', 'admin@mughtarib.abaadre.com', 'Admin', 'Admin@123'],
                ['Property Manager', 'manager@mughtarib.abaadre.com', 'Property Owner', 'Manager@123'],
                ['Regular User', 'user@mughtarib.abaadre.com', 'User', 'User@123'],
                ['Content Editor', 'editor@mughtarib.abaadre.com', 'Property Owner (Editor)', 'Editor@123'],
                ['Support Staff', 'support@mughtarib.abaadre.com', 'Property Owner (Support)', 'Support@123'],
            ]
        );
    }
} 