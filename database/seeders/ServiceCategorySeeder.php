<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        ServiceCategory::firstOrCreate(
            ['slug' => 'ambulance-services'],
            ['name' => 'Ambulance Services', 'slug' => 'ambulance-services', 'service_type' => 'ambulance', 'sort_order' => 1, 'status' => true]
        );
        ServiceCategory::firstOrCreate(
            ['slug' => 'funeral-services'],
            ['name' => 'Funeral Services', 'slug' => 'funeral-services', 'service_type' => 'funeral', 'sort_order' => 2, 'status' => true]
        );
    }
}
