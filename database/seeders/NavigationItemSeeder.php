<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationItemSeeder extends Seeder
{
    public function run(): void
    {
        $headerItems = [
            ['label' => 'Home', 'link' => '/', 'location' => 'header', 'sort_order' => 1],
            ['label' => 'About', 'link' => '/about', 'location' => 'header', 'sort_order' => 2],
            ['label' => 'Services', 'link' => '/services', 'location' => 'header', 'sort_order' => 3],
            ['label' => 'Fleet', 'link' => '/fleet', 'location' => 'header', 'sort_order' => 4],
            ['label' => 'Contact', 'link' => '/contact', 'location' => 'header', 'sort_order' => 5],
        ];

        $footerItems = [
            ['label' => 'About Us', 'link' => '/about', 'location' => 'footer', 'sort_order' => 1],
            ['label' => 'Services', 'link' => '/services', 'location' => 'footer', 'sort_order' => 2],
            ['label' => 'Our Fleet', 'link' => '/fleet', 'location' => 'footer', 'sort_order' => 3],
            ['label' => 'Testimonials', 'link' => '/testimonials', 'location' => 'footer', 'sort_order' => 4],
            ['label' => 'FAQ', 'link' => '/faq', 'location' => 'footer', 'sort_order' => 5],
            ['label' => 'Contact', 'link' => '/contact', 'location' => 'footer', 'sort_order' => 6],
        ];

        foreach ($headerItems as $item) {
            NavigationItem::firstOrCreate(
                ['label' => $item['label'], 'location' => 'header'],
                $item + ['parent_id' => null, 'status' => true]
            );
        }

        foreach ($footerItems as $item) {
            NavigationItem::firstOrCreate(
                ['label' => $item['label'], 'location' => 'footer'],
                $item + ['parent_id' => null, 'status' => true]
            );
        }
    }
}
