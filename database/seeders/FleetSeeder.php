<?php

namespace Database\Seeders;

use App\Models\Fleet;
use App\Models\FleetCategory;
use App\Models\Mortuary;
use Illuminate\Database\Seeder;

class FleetSeeder extends Seeder
{
    public function run(): void
    {
        $funeralCat = FleetCategory::updateOrCreate(
            ['slug' => 'funeral-fleet'],
            [
                'name' => 'Funeral Fleet',
                'slug' => 'funeral-fleet',
                'subtitle' => 'Premium Funeral Vans',
                'description' => 'Providing respectful, dignified, and prestigious transport during difficult times. Our exclusive funeral fleet is available across all regions to ensure smooth final journeys.',
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&q=80',
                'type' => 'fleet',
                'sort_order' => 1,
                'status' => true,
            ]
        );

        $medicalCat = FleetCategory::updateOrCreate(
            ['slug' => 'medical-fleet'],
            [
                'name' => 'Medical Fleet',
                'slug' => 'medical-fleet',
                'subtitle' => 'Advanced Life Support Transport',
                'description' => 'Our Advanced Life Support (ALS) ambulances act as mobile ICUs, specifically engineered to provide critical care during high-speed transit. Outfitted with state-of-the-art medical equipment and staffed by highly trained professionals.',
                'image' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=1200&q=80',
                'type' => 'fleet',
                'sort_order' => 2,
                'status' => true,
            ]
        );

        $mortuaryCat = FleetCategory::updateOrCreate(
            ['slug' => 'mortuary-services'],
            [
                'name' => 'Mortuary Services',
                'slug' => 'mortuary-services',
                'subtitle' => 'Freezer Boxes & Care',
                'description' => 'Comprehensive end-to-end mortuary care, embalming, and international repatriation services. Handled with the utmost respect and professionalism.',
                'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=1200&q=80',
                'type' => 'mortuary',
                'sort_order' => 3,
                'status' => true,
            ]
        );

        $funeralVehicles = [
            ['name' => 'Mercedes-Benz', 'slug' => 'mercedes-benz-funeral', 'description' => 'Ultra-luxury, peaceful, and highly prestigious final journey vehicle.', 'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800&q=80'],
            ['name' => 'Toyota Innova', 'slug' => 'toyota-innova-funeral', 'description' => 'Smooth, air-conditioned, and comfortable transit tailored for the family.', 'image' => 'https://images.unsplash.com/photo-1623869675787-8895b1e2e126?w=800&q=80'],
            ['name' => 'Glass-Tempo', 'slug' => 'glass-tempo-funeral', 'description' => 'Custom-built transparent sides allowing respectful public viewing en route.', 'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800&q=80'],
            ['name' => 'Maruti Omni', 'slug' => 'maruti-omni-funeral', 'description' => 'Highly accessible and reliable for navigating narrow city streets.', 'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=800&q=80'],
        ];

        foreach ($funeralVehicles as $i => $v) {
            Fleet::updateOrCreate(
                ['slug' => $v['slug']],
                [
                    'fleet_category_id' => $funeralCat->id,
                    'name' => $v['name'],
                    'slug' => $v['slug'],
                    'category' => 'Funeral Fleet',
                    'description' => $v['description'],
                    'image' => $v['image'],
                    'is_available' => true,
                    'sort_order' => $i + 1,
                ]
            );
        }

        $medicalVehicles = [
            ['name' => 'Mobile ICU on Wheels', 'slug' => 'mobile-icu-on-wheels', 'description' => 'Fully functioning intensive care units designed to sustain critical patients seamlessly during transit.', 'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=800&q=80'],
            ['name' => 'Advanced Cardiac Support', 'slug' => 'advanced-cardiac-support', 'description' => 'ACLS certified ambulances carrying defibrillators, ventilators, and complete cardiac response gear.', 'image' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=800&q=80'],
            ['name' => 'Pan-India Transport', 'slug' => 'pan-india-transport', 'description' => 'Long-distance, high-stability patient transfers covering all major cities and states across India safely.', 'image' => 'https://images.unsplash.com/photo-1532936781282-9b997e3acbad?w=800&q=80'],
            ['name' => 'Intercity Chennai', 'slug' => 'intercity-chennai', 'description' => 'Rapid response intercity transport inside Chennai with fully air-conditioned and non-AC options.', 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80'],
        ];

        foreach ($medicalVehicles as $i => $v) {
            Fleet::updateOrCreate(
                ['slug' => $v['slug']],
                [
                    'fleet_category_id' => $medicalCat->id,
                    'name' => $v['name'],
                    'slug' => $v['slug'],
                    'category' => 'Medical Fleet',
                    'description' => $v['description'],
                    'image' => $v['image'],
                    'is_available' => true,
                    'sort_order' => $i + 1,
                ]
            );
        }

        $mortuaryItems = [
            ['title' => 'Freezer Boxes', 'slug' => 'freezer-boxes', 'description' => 'Preservation units available in VIP, MID, and BASE options to suit all family needs.', 'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=800&q=80'],
            ['title' => 'Premium Coffins', 'slug' => 'premium-coffins', 'description' => 'Beautifully crafted coffins available in V.V.I.P, V.I.P, MID, and BASE variations.', 'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80'],
            ['title' => 'Private Mortuary', 'slug' => 'private-mortuary', 'description' => 'Complete, highly sanitary, and respectful private mortuary facilities.', 'image' => 'https://images.unsplash.com/photo-1516549655169-0f7d0a45d0a0?w=800&q=80'],
            ['title' => 'Flight Repatriation', 'slug' => 'flight-repatriation', 'description' => 'Certified dead body embalming and flight repatriation transport to any destination.', 'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&q=80'],
        ];

        foreach ($mortuaryItems as $i => $item) {
            Mortuary::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'image' => $item['image'],
                    'sort_order' => $i + 1,
                ]
            );
        }
    }
}
