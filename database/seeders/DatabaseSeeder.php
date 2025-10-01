<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');
        
        // Create admin user first
        if (!User::where('email', 'admin@kessly.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@kessly.com',
                'password' => bcrypt('password'),
            ]);
            $this->command->info('✅ Admin user created (admin@kessly.com / password)');
        } else {
            $this->command->info('ℹ️  Admin user already exists');
        }

        // Create test user
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
            $this->command->info('✅ Test user created (test@example.com / password)');
        } else {
            $this->command->info('ℹ️  Test user already exists');
        }

        // Create additional users
        $existingUserCount = User::count();
        $usersToCreate = max(0, 17 - $existingUserCount); // Target 17 total users
        if ($usersToCreate > 0) {
            User::factory($usersToCreate)->create();
            $this->command->info("✅ Created {$usersToCreate} additional users");
        } else {
            $this->command->info('ℹ️  Sufficient users already exist');
        }

        // Seed in proper order to maintain relationships
        $this->call([
            // Foundation data (no dependencies)
            RoleSeeder::class,
            CategorySeeder::class,
            BranchSeeder::class,
            
            // Business entities (depend on foundation)
            SupplierSeeder::class,
            ProductSeeder::class, // depends on categories and suppliers
            CustomerSeeder::class, // depends on users for notes
            EmployeeSeeder::class, // depends on branches and roles
            
            // Transactional data (depends on business entities)
            OrderSeeder::class, // depends on customers, products, branches
            InvoiceSeeder::class, // depends on customers
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary of seeded data:');
        $this->command->info('- Users: ' . \App\Models\User::count());
        $this->command->info('- Roles: ' . \App\Models\Role::count());
        $this->command->info('- Categories: ' . \App\Models\Category::count());
        $this->command->info('- Branches: ' . \App\Models\Branch::count());
        $this->command->info('- Suppliers: ' . \App\Models\Supplier::count());
        $this->command->info('- Products: ' . \App\Models\Product::count());
        $this->command->info('- Customers: ' . \App\Models\Customer::count());
        $this->command->info('- Employees: ' . \App\Models\Employee::count());
        $this->command->info('- Orders: ' . \App\Models\Order::count());
        $this->command->info('- Order Items: ' . \App\Models\OrderItem::count());
        $this->command->info('- Invoices: ' . \App\Models\Invoice::count());
        $this->command->info('- Customer Notes: ' . \App\Models\CustomerNote::count());
        $this->command->info('');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('Email: admin@kessly.com');
        $this->command->info('Password: password');
    }
}
