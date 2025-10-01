<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator', 'description' => 'Full system access and management'],
            ['name' => 'Manager', 'description' => 'Department management and reporting'],
            ['name' => 'Sales Manager', 'description' => 'Sales team and customer management'],
            ['name' => 'Sales Representative', 'description' => 'Customer interaction and sales'],
            ['name' => 'Inventory Manager', 'description' => 'Inventory and product management'],
            ['name' => 'Accountant', 'description' => 'Financial records and reporting'],
            ['name' => 'HR Manager', 'description' => 'Human resources management'],
            ['name' => 'Warehouse Supervisor', 'description' => 'Warehouse operations oversight'],
            ['name' => 'Customer Service', 'description' => 'Customer support and service'],
            ['name' => 'Employee', 'description' => 'Basic employee access'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }

        $this->command->info('✅ Roles seeded successfully!');
    }
}