<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wineSuppliers = [
            // International Wine Suppliers
            ['name' => 'Bordeaux Wine Exports', 'country' => 'France', 'specialty' => 'French wines and Champagne'],
            ['name' => 'Tuscan Vineyard Co.', 'country' => 'Italy', 'specialty' => 'Italian wines and Prosecco'],
            ['name' => 'Barossa Premium Wines', 'country' => 'Australia', 'specialty' => 'Australian Shiraz and Cabernet'],
            ['name' => 'Stellenbosch Wine Traders', 'country' => 'South Africa', 'specialty' => 'South African wines'],
            ['name' => 'Rioja Wine Distribution', 'country' => 'Spain', 'specialty' => 'Spanish wines and Cava'],
            ['name' => 'Rhine Valley Vineyards', 'country' => 'Germany', 'specialty' => 'German Riesling and white wines'],
            ['name' => 'Marlborough Wine Co.', 'country' => 'New Zealand', 'specialty' => 'Sauvignon Blanc and Pinot Noir'],
            ['name' => 'Douro Valley Exports', 'country' => 'Portugal', 'specialty' => 'Portuguese wines and Port'],
            
            // Local Kenyan Wine Suppliers
            ['name' => 'Naivasha Wines Limited', 'country' => 'Kenya', 'specialty' => 'Local Kenyan wines'],
            ['name' => 'Rift Valley Vineyards', 'country' => 'Kenya', 'specialty' => 'Highland wines and blends'],
            ['name' => 'Kenya Wine Company', 'country' => 'Kenya', 'specialty' => 'Local production and imports'],
            
            // Wine Accessories & Equipment
            ['name' => 'Premium Wine Accessories Ltd', 'country' => 'Kenya', 'specialty' => 'Wine glasses, decanters, accessories'],
            ['name' => 'Cork & Bottle Supplies', 'country' => 'Kenya', 'specialty' => 'Wine storage and serving equipment'],
            ['name' => 'Elite Wine Storage Solutions', 'country' => 'Kenya', 'specialty' => 'Wine refrigeration and storage'],
        ];
        
        $supplier = $this->faker->randomElement($wineSuppliers);
        
        // Generate unique contact email with random elements
        $emailDomain = strtolower(str_replace([' ', '.', ','], ['', '', ''], $supplier['name']));
        $uniqueEmail = $this->faker->unique()->safeEmail();
        
        // Use the supplier's domain style but ensure uniqueness
        $emailPrefix = $this->faker->randomElement(['info', 'sales', 'contact', 'orders']);
        $uniqueSuffix = $this->faker->numberBetween(100, 999);
        $finalEmail = $emailPrefix . $uniqueSuffix . '@' . substr($emailDomain, 0, 15) . '.com';
        
        // Kenyan addresses for local suppliers, international for others
        if ($supplier['country'] === 'Kenya') {
            $kenyanAreas = [
                'Industrial Area, Nairobi', 'Westlands, Nairobi', 'Mombasa Road, Nairobi',
                'Thika Road, Nairobi', 'Nakuru Town', 'Eldoret Industrial Area',
                'Mombasa Port Area', 'Kisumu Lakeside'
            ];
            $address = $this->faker->randomElement($kenyanAreas);
            $phone = $this->faker->numerify('+254 20 ### ####'); // Kenyan landline
        } else {
            $address = $supplier['country'] . ' - ' . $this->faker->city() . ', ' . $this->faker->streetAddress();
            $phone = $this->faker->phoneNumber();
        }
        
        return [
            'name' => $supplier['name'],
            'contact_email' => $finalEmail,
            'phone' => $phone,
            'address' => $address,
            'notes' => 'Specializes in ' . $supplier['specialty'] . '. Based in ' . $supplier['country'] . '.',
        ];
    }

    /**
     * Create a premium wine supplier.
     */
    public function premium(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'notes' => 'Premium wine supplier with exclusive vintage collections. Minimum order quantities apply.',
            ];
        });
    }

    /**
     * Create a local Kenyan supplier.
     */
    public function local(): static
    {
        return $this->state(function (array $attributes) {
            $kenyanSuppliers = [
                'Naivasha Wines Limited', 'Rift Valley Vineyards', 'Kenya Wine Company'
            ];
            return [
                'name' => $this->faker->randomElement($kenyanSuppliers),
                'notes' => 'Local Kenyan wine producer. Fast delivery within Kenya.',
            ];
        });
    }

    /**
     * Create a high-volume international supplier.
     */
    public function international(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'notes' => 'International wine supplier with bulk ordering capabilities. Shipping lead times 2-4 weeks.',
            ];
        });
    }
}