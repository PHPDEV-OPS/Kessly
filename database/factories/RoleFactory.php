<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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

        $role = $this->faker->randomElement($roles);

        return [
            'name' => $role['name'],
            'description' => $role['description'],
        ];
    }

    /**
     * Create an admin role.
     */
    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Administrator',
                'description' => 'Full system access and management',
            ];
        });
    }

    /**
     * Create a manager role.
     */
    public function manager(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Manager',
                'description' => 'Department management and reporting',
            ];
        });
    }

    /**
     * Create an employee role.
     */
    public function employee(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Employee',
                'description' => 'Basic employee access',
            ];
        });
    }
}