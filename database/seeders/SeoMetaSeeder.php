<?php

namespace Database\Seeders;

use App\Models\SeoMetum;
use Illuminate\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'home' => ['R.G. Ambulance Service | Premium Emergency Medical Transport', 'Leading 24/7 emergency ambulance service with advanced life support fleet and compassionate medical professionals.'],
            'about' => ['About Us | R.G. Ambulance Service', 'Learn about our mission, team, and commitment to excellence in emergency medical transport since 2010.'],
            'services' => ['Medical Services | R.G. Ambulance Service', 'Comprehensive ambulance services including BLS, ALS, ICU transport, and patient transfer solutions.'],
            'fleet' => ['Our Fleet | R.G. Ambulance Service', 'Explore our fleet of advanced life support ambulances and medical transport vehicles.'],
            'contact' => ['Contact Us | R.G. Ambulance Service', 'Reach our 24/7 emergency helpline or send an inquiry for non-emergency bookings.'],
        ];

        foreach ($pages as $page => [$title, $desc]) {
            SeoMetum::firstOrCreate(
                ['page_name' => $page],
                [
                    'page_name' => $page,
                    'meta_title' => $title,
                    'meta_description' => $desc,
                ]
            );
        }
    }
}
