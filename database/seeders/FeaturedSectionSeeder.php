<?php

namespace Database\Seeders;

use App\Models\FeaturedSection;
use Illuminate\Database\Seeder;

class FeaturedSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['icon' => 'clock', 'title' => '24/7 Availability', 'description' => 'Round-the-clock emergency response and funeral support, every day of the year.', 'section_type' => 'services', 'sort_order' => 1, 'status' => true],
            ['icon' => 'lightning-charge', 'title' => 'Quick Response Time', 'description' => 'Rapid dispatch with GPS-tracked fleet ensuring help arrives when every second counts.', 'section_type' => 'services', 'sort_order' => 2, 'status' => true],
            ['icon' => 'people', 'title' => 'Experienced & Caring Staff', 'description' => 'Trained paramedics, EMTs, and funeral professionals dedicated to compassionate service.', 'section_type' => 'services', 'sort_order' => 3, 'status' => true],
            ['icon' => 'truck-front', 'title' => 'Modern Ambulance Fleet', 'description' => 'State-of-the-art ICU, ventilator, and oxygen-equipped ambulances for safe transport.', 'section_type' => 'services', 'sort_order' => 4, 'status' => true],
            ['icon' => 'cash-coin', 'title' => 'Affordable & Transparent Pricing', 'description' => 'Clear, upfront pricing with no hidden charges — quality care at fair rates.', 'section_type' => 'services', 'sort_order' => 5, 'status' => true],
            ['icon' => 'shield-check', 'title' => 'Trusted by Families & Healthcare Providers', 'description' => 'Preferred partner for hospitals, nursing homes, and families across the region.', 'section_type' => 'services', 'sort_order' => 6, 'status' => true],
        ];

        foreach ($sections as $s) {
            FeaturedSection::firstOrCreate(
                ['title' => $s['title']],
                $s
            );
        }
    }
}
