<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Health Tips', 'slug' => 'health-tips', 'status' => true],
            ['name' => 'Service Updates', 'slug' => 'service-updates', 'status' => true],
            ['name' => 'Community', 'slug' => 'community', 'status' => true],
        ];

        foreach ($categories as $cat) {
            BlogCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
