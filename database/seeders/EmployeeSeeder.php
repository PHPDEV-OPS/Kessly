<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $roles = Role::all();
        $users = User::all();

        if ($branches->isEmpty() || $roles->isEmpty()) {
            $this->command->warn('Branches and roles must be seeded first!');
            return;
        }

        $userIndex = 0;

        // Create managers for each branch
        foreach ($branches as $branch) {
            Employee::factory()
                ->manager()
                ->forBranch($branch)
                ->create([
                    'user_id' => $users->get($userIndex % $users->count())->id,
                ]);
            $userIndex++;
        }

        // Create wine sales representatives
        for ($i = 0; $i < 12; $i++) {
            Employee::factory()
                ->salesRep()
                ->create([
                    'branch_id' => $branches->random()->id,
                    'user_id' => $users->get($userIndex % $users->count())->id,
                ]);
            $userIndex++;
        }

        // Create sommeliers for wine expertise
        for ($i = 0; $i < 3; $i++) {
            Employee::factory()
                ->sommelier()
                ->create([
                    'branch_id' => $branches->random()->id,
                    'user_id' => $users->get($userIndex % $users->count())->id,
                ]);
            $userIndex++;
        }

        // Create general employees
        for ($i = 0; $i < 30; $i++) {
            Employee::factory()
                ->active()
                ->create([
                    'branch_id' => $branches->random()->id,
                    'user_id' => $users->get($userIndex % $users->count())->id,
                ]);
            $userIndex++;
        }

        // Create some inactive employees
        for ($i = 0; $i < 5; $i++) {
            Employee::factory()
                ->create([
                    'employment_status' => 'inactive',
                    'branch_id' => $branches->random()->id,
                    'user_id' => $users->get($userIndex % $users->count())->id,
                ]);
            $userIndex++;
        }

        $this->command->info('✅ Employees seeded successfully!');
    }
}