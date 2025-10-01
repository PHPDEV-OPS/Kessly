<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create headquarters first (check if exists)
        if (!Branch::where('name', 'Headquarters')->exists()) {
            Branch::factory()->headquarters()->create();
        }

        // Create additional branches with unique codes
        $existingBranches = Branch::count();
        $branchesToCreate = max(0, 10 - $existingBranches);
        
        if ($branchesToCreate > 0) {
            for ($i = 0; $i < $branchesToCreate; $i++) {
                $attempts = 0;
                do {
                    try {
                        if ($i < 8) {
                            Branch::factory()->active()->create();
                        } else {
                            Branch::factory()->inactive()->create();
                        }
                        break;
                    } catch (\Exception $e) {
                        $attempts++;
                        if ($attempts > 5) break; // Prevent infinite loop
                    }
                } while ($attempts <= 5);
            }
        }

        $this->command->info('✅ Branches seeded successfully!');
    }
}