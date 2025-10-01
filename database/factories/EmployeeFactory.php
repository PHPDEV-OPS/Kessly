<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Branch;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            'Sales', 'Marketing', 'Human Resources', 'Finance', 'Operations',
            'IT', 'Customer Service', 'Warehouse', 'Management', 'Administration'
        ];

        $positions = [
            'Manager', 'Assistant Manager', 'Supervisor', 'Specialist', 'Coordinator',
            'Analyst', 'Representative', 'Executive', 'Administrator', 'Clerk'
        ];

        return [
            'employee_id' => 'EMP-' . $this->faker->unique()->numerify('####'),
            'user_id' => null, // Will be set by seeder
            'branch_id' => Branch::factory(),
            'department' => $this->faker->randomElement($departments),
            'position' => $this->faker->randomElement($positions),
            'hire_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
            'employment_status' => $this->faker->randomElement(['active', 'inactive', 'terminated']),
            'manager_id' => null, // Will be set later for hierarchy
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'emergency_contact' => $this->faker->name(),
            'emergency_phone' => $this->faker->phoneNumber(),
            'notes' => $this->faker->optional(0.3)->paragraph(),
        ];
    }

    /**
     * Create an active employee.
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'employment_status' => 'active',
                'hire_date' => $this->faker->dateTimeBetween('-3 years', '-1 month'),
            ];
        });
    }

    /**
     * Create a manager.
     */
    public function manager(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'position' => 'Manager',
                'department' => $this->faker->randomElement(['Sales', 'Operations', 'Finance', 'HR']),
                'salary' => $this->faker->randomFloat(2, 60000, 120000),
                'employment_status' => 'active',
            ];
        });
    }

    /**
     * Create a sales representative.
     */
    public function salesRep(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'department' => 'Sales',
                'position' => 'Sales Representative',
                'salary' => $this->faker->randomFloat(2, 35000, 75000),
                'employment_status' => 'active',
            ];
        });
    }

    /**
     * Create an employee for a specific branch.
     */
    public function forBranch(Branch $branch): static
    {
        return $this->state(function (array $attributes) use ($branch) {
            return [
                'branch_id' => $branch->id,
            ];
        });
    }
}