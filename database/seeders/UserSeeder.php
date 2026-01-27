<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'Administrator')->first();
        $salesManagerRole = Role::where('name', 'Sales Manager')->first();
        $salesRepRole = Role::where('name', 'Sales Representative')->first();
        $branchManagerRole = Role::where('name', 'Branch Manager')->first();
        $hrManagerRole = Role::where('name', 'HR Manager')->first();

        // Create test users
        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@kessly.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id,
                'is_verified' => true,
            ],
            [
                'name' => 'John Sales Manager',
                'email' => 'sales.manager@kessly.com',
                'password' => Hash::make('password'),
                'role_id' => $salesManagerRole?->id,
                'is_verified' => true,
            ],
            [
                'name' => 'Jane Sales Rep',
                'email' => 'sales.rep@kessly.com',
                'password' => Hash::make('password'),
                'role_id' => $salesRepRole?->id,
                'is_verified' => true,
            ],
            [
                'name' => 'Bob Branch Manager',
                'email' => 'branch.manager@kessly.com',
                'password' => Hash::make('password'),
                'role_id' => $branchManagerRole?->id,
                'is_verified' => true,
            ],
            [
                'name' => 'Alice HR Manager',
                'email' => 'hr.manager@kessly.com',
                'password' => Hash::make('password'),
                'role_id' => $hrManagerRole?->id,
                'is_verified' => true,
            ],
            [
                'name' => 'Unverified User',
                'email' => 'unverified@kessly.com',
                'password' => Hash::make('password'),
                'role_id' => $salesRepRole?->id,
                'is_verified' => false,
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('✅ Test users created successfully!');
        $this->command->info('📧 Verified users can login immediately');
        $this->command->info('⏳ Unverified user needs admin approval');
    }
}
