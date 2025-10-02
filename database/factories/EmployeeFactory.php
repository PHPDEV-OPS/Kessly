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
        $wineDepartments = [
            'Wine Sales', 'Wine Procurement', 'Inventory Management', 'Customer Relations', 'Logistics',
            'Quality Control', 'Marketing', 'Finance', 'Human Resources', 'Operations'
        ];

        $winePositions = [
            'Wine Sales Manager', 'Wine Consultant', 'Sommelier', 'Procurement Specialist', 'Inventory Coordinator',
            'Customer Relations Executive', 'Logistics Coordinator', 'Quality Control Analyst', 'Marketing Executive',
            'Store Manager', 'Sales Representative', 'Warehouse Supervisor', 'Delivery Coordinator'
        ];

        $kenyanNames = [
            'John Mwangi', 'Grace Wanjiku', 'David Kiprotich', 'Mary Njeri', 'Samuel Ochieng',
            'Faith Akinyi', 'Peter Kamau', 'Lucy Wambui', 'James Kipkorir', 'Catherine Nyambura',
            'Joseph Macharia', 'Agnes Wairimu', 'Daniel Rotich', 'Jane Wanjiru', 'Francis Otieno',
            'Eunice Muthoni', 'Michael Kibet', 'Sarah Wangari', 'Patrick Mbugua', 'Mercy Achieng'
        ];

        $kenyanAreas = [
            'Westlands, Nairobi', 'Karen, Nairobi', 'Lavington, Nairobi', 'Kileleshwa, Nairobi',
            'Runda, Nairobi', 'Muthaiga, Nairobi', 'South B, Nairobi', 'South C, Nairobi',
            'Nyali, Mombasa', 'Milimani, Nakuru', 'Pioneer, Eldoret', 'Migosi, Kisumu'
        ];

        return [
            'employee_id' => 'KWD-' . $this->faker->unique()->numerify('####'), // Kessly Wine Distribution
            'user_id' => null, // Will be set by seeder
            'branch_id' => Branch::factory(),
            'department' => $this->faker->randomElement($wineDepartments),
            'position' => $this->faker->randomElement($winePositions),
            'hire_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'salary' => $this->faker->randomFloat(2, 25000, 200000), // KES salaries
            'employment_status' => $this->faker->randomElement(['active', 'inactive', 'terminated']),
            'manager_id' => null, // Will be set later for hierarchy
            'phone' => $this->faker->numerify('+254 7## ### ###'),
            'address' => $this->faker->randomElement($kenyanAreas),
            'emergency_contact' => $this->faker->randomElement($kenyanNames),
            'emergency_phone' => $this->faker->numerify('+254 7## ### ###'),
            'notes' => $this->faker->optional(0.4)->randomElement([
                'Certified wine specialist with extensive knowledge of international wines',
                'Experienced in wine procurement and supplier relationship management',
                'Strong customer service skills with wine pairing expertise',
                'Logistics coordinator with knowledge of wine storage requirements',
                'Quality control specialist ensuring proper wine handling and storage'
            ]),
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
     * Create a wine manager.
     */
    public function manager(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'position' => $this->faker->randomElement(['Wine Sales Manager', 'Store Manager', 'Operations Manager']),
                'department' => $this->faker->randomElement(['Wine Sales', 'Operations', 'Wine Procurement']),
                'salary' => $this->faker->randomFloat(2, 80000, 200000), // KES
                'employment_status' => 'active',
            ];
        });
    }

    /**
     * Create a wine sales representative.
     */
    public function salesRep(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'department' => 'Wine Sales',
                'position' => $this->faker->randomElement(['Wine Sales Representative', 'Wine Consultant']),
                'salary' => $this->faker->randomFloat(2, 35000, 80000), // KES
                'employment_status' => 'active',
            ];
        });
    }

    /**
     * Create a sommelier.
     */
    public function sommelier(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'department' => 'Wine Sales',
                'position' => 'Sommelier',
                'salary' => $this->faker->randomFloat(2, 60000, 120000), // KES
                'employment_status' => 'active',
                'notes' => 'Certified sommelier with expertise in wine tasting and pairing recommendations',
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