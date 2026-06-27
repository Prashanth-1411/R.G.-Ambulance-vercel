<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'How to Handle Medical Emergencies',
                'slug' => 'handle-medical-emergencies',
                'excerpt' => 'Essential tips for staying calm and acting quickly during medical emergencies',
                'category_id' => 1,
                'author' => 'Dr. R. Gupta',
                'reading_time' => '5 min',
                'is_featured' => true,
                'status' => true,
            ],
            [
                'title' => 'Understanding Different Types of Ambulance Services',
                'slug' => 'types-of-ambulance-services',
                'excerpt' => 'A comprehensive guide to BLS, ALS, and patient transport services',
                'category_id' => 2,
                'author' => 'R.G. Ambulance Team',
                'reading_time' => '4 min',
                'is_featured' => true,
                'status' => true,
            ],
            [
                'title' => 'Community Health Initiative Launched',
                'slug' => 'community-health-initiative',
                'excerpt' => 'Our new community health awareness program reaches 10000+ people',
                'category_id' => 3,
                'author' => 'Admin',
                'reading_time' => '3 min',
                'is_featured' => false,
                'status' => true,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
