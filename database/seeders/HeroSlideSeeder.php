<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => '24/7 Emergency Ambulance Service',
                'subtitle' => 'Rapid response with advanced life support when every second counts — your trusted emergency medical partner',
                'badge_text' => 'Emergency Response',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=1920&q=80',
                'button_text' => 'Our Services',
                'button_link' => '/services',
                'button_text_2' => 'Contact Us',
                'button_link_2' => '/contact',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Advanced Life Support Ambulances',
                'subtitle' => 'Fully equipped mobile ICUs with trained paramedics and critical care equipment ready 24/7',
                'badge_text' => 'Advanced Care',
                'image' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=1920&q=80',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Compassionate Funeral & Mortuary Services',
                'subtitle' => 'Dignified transport, premium hearses, and complete mortuary care during life\'s most difficult moments',
                'badge_text' => 'Funeral Services',
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1920&q=80',
                'sort_order' => 3,
                'status' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::firstOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }
    }
}
