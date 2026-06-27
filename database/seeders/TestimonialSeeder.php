<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Rajesh Kumar', 'content' => 'Excellent service! They arrived within 10 minutes of my call. Very professional team.', 'rating' => 5, 'is_featured' => true, 'is_approved' => true, 'sort_order' => 1],
            ['name' => 'Priya Sharma', 'content' => 'The funeral service was handled with utmost dignity and respect. Thank you for your compassionate support.', 'rating' => 5, 'is_featured' => true, 'is_approved' => true, 'sort_order' => 2],
            ['name' => 'Amit Patel', 'content' => 'Regular patient transport for my father\'s dialysis. Always on time and very helpful staff.', 'rating' => 4, 'is_featured' => true, 'is_approved' => true, 'sort_order' => 3],
            ['name' => 'Sneha Reddy', 'content' => 'Best ambulance service in the city. Advanced life support ambulance saved my mother\'s life.', 'rating' => 5, 'is_featured' => false, 'is_approved' => true, 'sort_order' => 4],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(
                ['name' => $t['name'], 'content' => $t['content']],
                $t
            );
        }
    }
}
