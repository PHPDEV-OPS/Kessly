<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCompany = $this->faker->boolean(0.5); // 50% chance of being a company in wine business
        $customerTypes = ['individual', 'business', 'enterprise'];
        $statuses = ['active', 'inactive', 'prospect', 'blocked'];
        $paymentTerms = ['Net 30', 'Net 60', 'COD', 'Net 15', '2/10 Net 30', 'Upon Receipt', 'Cash on Delivery'];
        
        // Kenyan names and wine business context
        $kenyanNames = [
            'John Mwangi', 'Grace Wanjiku', 'David Kiprotich', 'Mary Njeri', 'Samuel Ochieng',
            'Faith Akinyi', 'Peter Kamau', 'Lucy Wambui', 'James Kipkorir', 'Catherine Nyambura',
            'Joseph Macharia', 'Agnes Wairimu', 'Daniel Rotich', 'Jane Wanjiru', 'Francis Otieno'
        ];
        
        $wineBusinesses = [
            'Vineyard Restaurant', 'Wine & Dine Ltd', 'Premium Cellars', 'Nairobi Wine Bar',
            'Rift Valley Wines', 'Safari Wine Collection', 'Tusker Wine Shop', 'Elite Wine Store',
            'Mombasa Wine Traders', 'Highlands Wine Company', 'Westlands Wine Boutique',
            'Karen Wine Cellar', 'Lavington Fine Wines', 'Muthaiga Wine Club'
        ];
        
        $kenyanCities = [
            'Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Malindi', 'Kitale', 
            'Garissa', 'Kakamega', 'Machakos', 'Meru', 'Nyeri', 'Kericho', 'Kisii'
        ];
        
        $kenyanAreas = [
            // Nairobi areas
            'Westlands', 'Karen', 'Lavington', 'Muthaiga', 'Kilimani', 'Kileleshwa', 'Runda',
            'Gigiri', 'Spring Valley', 'Riverside', 'Parklands', 'South B', 'South C',
            // Other major areas
            'Nyali', 'Bamburi', 'Milimani', 'Hurlingham', 'Upperhill', 'CBD'
        ];
        
        $name = $isCompany ? $this->faker->randomElement($wineBusinesses) : $this->faker->randomElement($kenyanNames);
        $customerType = $isCompany ? $this->faker->randomElement(['business', 'enterprise']) : 'individual';
        
        // Generate Kenyan phone numbers
        $phoneFormats = [
            '+254 7## ### ###',
            '+254 1## ### ###',
            '07## ### ###',
            '01## ### ###'
        ];
        
        return [
            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify($this->faker->randomElement($phoneFormats)),
            'mobile' => $this->faker->optional(0.9)->numerify($this->faker->randomElement(['+254 7## ### ###', '07## ### ###'])),
            'company' => $isCompany ? $name : $this->faker->optional(0.3)->randomElement($wineBusinesses),
            'website' => $this->faker->optional(0.4)->url(),
            'address' => $this->faker->randomElement($kenyanAreas) . ', ' . $this->faker->streetName() . ' Road',
            'city' => $this->faker->randomElement($kenyanCities),
            'state' => $this->faker->randomElement([
                'Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Uasin Gishu', 'Kiambu',
                'Machakos', 'Meru', 'Nyeri', 'Kericho', 'Kisii', 'Kajiado'
            ]),
            'postal_code' => $this->faker->numerify('#####'),
            'country' => 'Kenya',
            'tax_id' => $this->faker->optional(0.7)->numerify('P05########'),
            'customer_type' => $customerType,
            'status' => $this->faker->randomElement($statuses),
            'credit_limit' => $this->faker->randomFloat(2, 5000, 500000), // KES amounts
            'payment_terms' => $this->faker->randomElement($paymentTerms),
            'notes' => $this->faker->optional(0.5)->randomElement([
                'Regular wine enthusiast, prefers red wines',
                'Restaurant owner, bulk wine orders',
                'Wine collector, interested in vintage wines',
                'Hotel chain buyer, seasonal orders',
                'Wine bar owner, premium selections preferred',
                'Corporate events planner, sparkling wines focus',
                'Retail wine shop, diverse portfolio needed'
            ]),
            'tags' => $this->faker->optional(0.7)->randomElements([
                'Wine Enthusiast', 'Restaurant', 'Hotel', 'Wine Bar', 'Retail Shop',
                'Corporate Client', 'Event Planner', 'Wine Collector', 'Bulk Buyer',
                'Premium Customer', 'Regular Customer', 'Seasonal Buyer'
            ], $this->faker->numberBetween(1, 3)),
            'last_contact' => $this->faker->optional(0.7)->dateTimeBetween('-6 months', 'now'),
            'total_orders' => $this->faker->numberBetween(0, 50),
            'total_spent' => $this->faker->randomFloat(2, 0, 250000), // KES amounts
            'avatar' => null,
        ];
    }

    /**
     * Create an active customer.
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'last_contact' => $this->faker->dateTimeBetween('-3 months', 'now'),
                'total_orders' => $this->faker->numberBetween(1, 50),
                'total_spent' => $this->faker->randomFloat(2, 100, 25000),
            ];
        });
    }

    /**
     * Create a VIP wine customer.
     */
    public function vip(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'customer_type' => 'enterprise',
                'status' => 'active',
                'credit_limit' => $this->faker->randomFloat(2, 100000, 1000000), // KES amounts
                'total_orders' => $this->faker->numberBetween(20, 100),
                'total_spent' => $this->faker->randomFloat(2, 50000, 500000), // KES amounts
                'tags' => ['Wine Collector', 'Premium Customer', 'High Volume', 'VIP'],
                'payment_terms' => 'Net 30',
            ];
        });
    }

    /**
     * Create a prospect customer.
     */
    public function prospect(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'prospect',
                'total_orders' => 0,
                'total_spent' => 0,
                'last_contact' => $this->faker->optional(0.5)->dateTimeBetween('-1 month', 'now'),
                'tags' => ['Prospect', 'New'],
            ];
        });
    }

    /**
     * Create an individual wine customer.
     */
    public function individual(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'customer_type' => 'individual',
                'company' => null,
                'website' => null,
                'credit_limit' => $this->faker->randomFloat(2, 5000, 50000), // KES amounts
                'tags' => ['Wine Enthusiast', 'Individual', 'Retail'],
            ];
        });
    }

    /**
     * Create a business wine customer.
     */
    public function business(): static
    {
        $wineBusinesses = [
            'The Wine Bar Karen', 'Nairobi Wine Company', 'Savanna Fine Wines', 
            'Mombasa Wine Traders', 'Highlands Wine Store', 'Elite Wine Collection'
        ];
        
        return $this->state(function (array $attributes) use ($wineBusinesses) {
            return [
                'customer_type' => 'business',
                'company' => $this->faker->randomElement($wineBusinesses),
                'website' => $this->faker->optional(0.6)->url(),
                'credit_limit' => $this->faker->randomFloat(2, 20000, 200000), // KES amounts
                'tax_id' => $this->faker->numerify('P05########'),
                'tags' => ['Wine Bar', 'Restaurant', 'Hotel', 'Wholesale'],
            ];
        });
    }
}