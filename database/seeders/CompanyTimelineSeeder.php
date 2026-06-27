<?php

namespace Database\Seeders;

use App\Models\CompanyTimeline;
use Illuminate\Database\Seeder;

class CompanyTimelineSeeder extends Seeder
{
    public function run(): void
    {
        $timeline = [
            ['year' => '2010', 'title' => 'Company Founded', 'description' => 'R.G. Ambulance Service established with 5 ambulances', 'sort_order' => 1, 'status' => true],
            ['year' => '2013', 'title' => 'Expanded Fleet', 'description' => 'Fleet expanded to 20 ambulances with ALS capabilities', 'sort_order' => 2, 'status' => true],
            ['year' => '2017', 'title' => 'ISO Certification', 'description' => 'Achieved ISO 9001:2015 certification', 'sort_order' => 3, 'status' => true],
            ['year' => '2020', 'title' => 'Funeral Services Launch', 'description' => 'Expanded services to include funeral and mortuary services', 'sort_order' => 4, 'status' => true],
            ['year' => '2024', 'title' => 'Pan-State Coverage', 'description' => 'Now serving across the entire state with 50+ ambulances', 'sort_order' => 5, 'status' => true],
        ];

        foreach ($timeline as $t) {
            CompanyTimeline::firstOrCreate(
                ['year' => $t['year'], 'title' => $t['title']],
                $t
            );
        }
    }
}
