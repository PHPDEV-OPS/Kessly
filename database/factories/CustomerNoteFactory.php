<?php

namespace Database\Factories;

use App\Models\CustomerNote;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerNote>
 */
class CustomerNoteFactory extends Factory
{
    protected $model = CustomerNote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $noteTypes = ['note', 'call', 'email', 'meeting', 'complaint', 'feedback'];
        $noteTemplates = [
            'call' => 'Phone call with customer regarding [topic]. Customer was [satisfied/concerned] about [issue].',
            'email' => 'Email correspondence about [subject]. Customer requested [information/service].',
            'meeting' => 'In-person meeting to discuss [topic]. Action items: [actions].',
            'note' => 'General note about customer interaction: [content].',
            'complaint' => 'Customer complaint about [issue]. Resolution: [resolution].',
            'feedback' => 'Customer feedback about [product/service]. Rating: [rating].',
        ];

        $type = $this->faker->randomElement($noteTypes);
        $template = $noteTemplates[$type];

        // Replace placeholders with realistic content
        $note = str_replace(
            ['[topic]', '[issue]', '[subject]', '[information/service]', '[actions]', '[content]', '[resolution]', '[product/service]', '[rating]', '[satisfied/concerned]'],
            [
                $this->faker->words(3, true),
                $this->faker->words(2, true),
                $this->faker->words(4, true),
                $this->faker->randomElement(['product information', 'pricing details', 'delivery status', 'technical support']),
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->randomElement(['our products', 'our services', 'delivery options']),
                $this->faker->randomElement(['Excellent', 'Good', 'Average', 'Poor']),
                $this->faker->randomElement(['satisfied', 'concerned']),
            ],
            $template
        );

        return [
            'customer_id' => null, // Will be set by seeder
            'user_id' => null, // Will be set by seeder
            'note_type' => $type,
            'subject' => $this->faker->sentence(4),
            'content' => $note . ' ' . $this->faker->optional(0.7)->paragraph(),
            'is_private' => $this->faker->boolean(0.2), // 20% chance of being private
            'follow_up_date' => $this->faker->optional(0.3)->dateTimeBetween('now', '+1 month'),
        ];
    }

    /**
     * Create a private note.
     */
    public function private(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_private' => true,
                'note_type' => $this->faker->randomElement(['complaint', 'note', 'meeting']),
            ];
        });
    }

    /**
     * Create a recent note.
     */
    public function recent(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
                'updated_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }

    /**
     * Create a note for a specific customer.
     */
    public function forCustomer(Customer $customer): static
    {
        return $this->state(function (array $attributes) use ($customer) {
            return [
                'customer_id' => $customer->id,
            ];
        });
    }
}