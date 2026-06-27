<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $ambulanceCat = \App\Models\ServiceCategory::where('service_type', 'ambulance')->first();
        $funeralCat = \App\Models\ServiceCategory::where('service_type', 'funeral')->first();

        $services = [
            [
                'title' => 'ICU / Mobile ICU',
                'slug' => 'icu-mobile-icu',
                'short_description' => 'Advanced Cardiac Life Support (ACLS) transfers all over India. Fully equipped AC and Non-AC mobile ICUs for critical patient care.',
                'description' => 'Advanced Cardiac Life Support (ACLS) transfers all over India. Our fully equipped AC and Non-AC mobile ICUs provide critical patient care with ventilators, cardiac monitors, infusion pumps, and trained intensivists on board for seamless inter-hospital and pan-India transfers.',
                'service_type' => 'ambulance',
                'category_id' => $ambulanceCat?->id,
                'icon' => 'heart-pulse',
                'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=800&q=80',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Road Ambulance',
                'slug' => 'road-ambulance',
                'short_description' => 'Reliable intercity transfers within Chennai and comprehensive patient transport services throughout India.',
                'description' => 'Reliable intercity transfers within Chennai and comprehensive patient transport services throughout India. Our road ambulance network ensures safe, timely, and comfortable patient movement with BLS and ALS options for every medical requirement.',
                'service_type' => 'ambulance',
                'category_id' => $ambulanceCat?->id,
                'icon' => 'truck',
                'image' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=800&q=80',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Flight Transport',
                'slug' => 'flight-transport',
                'short_description' => 'Professional dead body embalming and flight transport services. Respectful repatriation to any destination.',
                'description' => 'Professional dead body embalming and flight transport services with complete documentation support. We provide respectful repatriation to any domestic or international destination, handled with dignity and full compliance with aviation regulations.',
                'service_type' => 'funeral',
                'category_id' => $funeralCat?->id,
                'icon' => 'airplane',
                'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&q=80',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Funeral Service',
                'slug' => 'funeral-service',
                'short_description' => 'Compassionate funeral services with dignity and respect for all regions.',
                'description' => 'Compassionate funeral services delivered with dignity and respect across all regions. From funeral transport and ceremony coordination to family support, our team ensures every final journey is handled with utmost care and professionalism.',
                'service_type' => 'funeral',
                'category_id' => $funeralCat?->id,
                'icon' => 'flower1',
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Royal VIP Send Off',
                'slug' => 'royal-vip-send-off',
                'short_description' => 'Premium VIP send-off services with utmost respect and dignity.',
                'description' => 'Premium VIP send-off services designed for families who expect nothing less than excellence. Featuring luxury vehicles, dedicated coordinators, floral arrangements, and bespoke ceremony planning with utmost respect and dignity.',
                'service_type' => 'funeral',
                'category_id' => $funeralCat?->id,
                'icon' => 'gem',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80',
                'is_featured' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                array_merge($service, ['status' => true])
            );
        }
    }
}
