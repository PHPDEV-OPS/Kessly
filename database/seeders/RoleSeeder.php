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
            ['name' => 'Administrator', 'description' => 'Full system access and management', 'permissions' => 'manage_users,manage_roles,view_all_reports,manage_settings'],
            ['name' => 'Manager', 'description' => 'Department management and reporting', 'permissions' => 'view_reports,manage_department'],
            ['name' => 'Sales Manager', 'description' => 'Sales team and customer management', 'permissions' => 'manage_sales,view_sales_reports,manage_customers,manage_orders'],
            ['name' => 'Sales Representative', 'description' => 'Customer interaction and sales', 'permissions' => 'view_customers,create_orders,view_own_sales'],
            ['name' => 'Branch Manager', 'description' => 'Branch operations and management', 'permissions' => 'manage_branch,view_branch_reports,manage_branch_inventory'],
            ['name' => 'Inventory Manager', 'description' => 'Inventory and product management', 'permissions' => 'manage_inventory,view_inventory_reports,manage_products'],
            ['name' => 'Accountant', 'description' => 'Financial records and reporting', 'permissions' => 'view_financial_reports,manage_invoices,manage_expenses'],
            ['name' => 'HR Manager', 'description' => 'Human resources management', 'permissions' => 'manage_employees,view_hr_reports,manage_payroll'],
            ['name' => 'Warehouse Supervisor', 'description' => 'Warehouse operations oversight', 'permissions' => 'manage_warehouse,view_inventory'],
            ['name' => 'Customer Service', 'description' => 'Customer support and service', 'permissions' => 'view_customers,manage_customer_service'],
            ['name' => 'Employee', 'description' => 'Basic employee access', 'permissions' => 'view_own_profile'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'permissions' => $role['permissions'] ?? null
                ]
            );
        }

        $this->command->info('✅ Roles seeded successfully!');
    }
}