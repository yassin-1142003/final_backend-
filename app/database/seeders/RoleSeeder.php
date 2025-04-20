<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator'
        ]);

        Role::create([
            'name' => 'user',
            'description' => 'Regular user'
        ]);
    }
} 