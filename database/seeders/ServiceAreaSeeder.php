<?php

namespace Database\Seeders;

use App\Models\ServiceArea;
use Illuminate\Database\Seeder;

class ServiceAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['name' => 'Mumbai City', 'slug' => 'mumbai-city', 'region' => 'Maharashtra'],
            ['name' => 'Navi Mumbai', 'slug' => 'navi-mumbai', 'region' => 'Maharashtra'],
            ['name' => 'Thane', 'slug' => 'thane', 'region' => 'Maharashtra'],
            ['name' => 'Pune', 'slug' => 'pune', 'region' => 'Maharashtra'],
            ['name' => 'Delhi NCR', 'slug' => 'delhi-ncr', 'region' => 'Delhi'],
            ['name' => 'Bengaluru', 'slug' => 'bengaluru', 'region' => 'Karnataka'],
            ['name' => 'Chennai', 'slug' => 'chennai', 'region' => 'Tamil Nadu'],
            ['name' => 'Hyderabad', 'slug' => 'hyderabad', 'region' => 'Telangana'],
            ['name' => 'Ahmedabad', 'slug' => 'ahmedabad', 'region' => 'Gujarat'],
            ['name' => 'Kolkata', 'slug' => 'kolkata', 'region' => 'West Bengal'],
            ['name' => 'Jaipur', 'slug' => 'jaipur', 'region' => 'Rajasthan'],
            ['name' => 'Lucknow', 'slug' => 'lucknow', 'region' => 'Uttar Pradesh'],
        ];

        foreach ($areas as $i => $area) {
            ServiceArea::firstOrCreate(
                ['slug' => $area['slug']],
                array_merge($area, [
                    'is_active' => true,
                    'sort_order' => $i + 1,
                ])
            );
        }
    }
}
