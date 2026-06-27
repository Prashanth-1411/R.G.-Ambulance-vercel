<?php

namespace Database\Seeders;

use App\Models\ServiceFeature;
use Illuminate\Database\Seeder;

class ServiceFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['service_id' => 1, 'feature' => 'Trained EMTs', 'sort_order' => 1],
            ['service_id' => 1, 'feature' => 'Basic medical equipment', 'sort_order' => 2],
            ['service_id' => 1, 'feature' => 'Oxygen cylinder', 'sort_order' => 3],
            ['service_id' => 1, 'feature' => 'Stretcher with locking system', 'sort_order' => 4],
            ['service_id' => 2, 'feature' => 'Ventilator support', 'sort_order' => 1],
            ['service_id' => 2, 'feature' => 'Defibrillator', 'sort_order' => 2],
            ['service_id' => 2, 'feature' => 'ICU-equivalent monitoring', 'sort_order' => 3],
            ['service_id' => 2, 'feature' => 'Paramedic doctor on board', 'sort_order' => 4],
            ['service_id' => 3, 'feature' => 'Ambulance chair', 'sort_order' => 1],
            ['service_id' => 3, 'feature' => 'Scheduled pickups', 'sort_order' => 2],
            ['service_id' => 3, 'feature' => 'Door-to-door service', 'sort_order' => 3],
            ['service_id' => 3, 'feature' => 'Attendant support', 'sort_order' => 4],
            ['service_id' => 4, 'feature' => 'Hearse vehicles', 'sort_order' => 1],
            ['service_id' => 4, 'feature' => 'Professional drivers', 'sort_order' => 2],
            ['service_id' => 4, 'feature' => 'Flower arrangements', 'sort_order' => 3],
            ['service_id' => 4, 'feature' => 'Religious accommodation', 'sort_order' => 4],
            ['service_id' => 5, 'feature' => 'Temperature-controlled storage', 'sort_order' => 1],
            ['service_id' => 5, 'feature' => 'Embalming services', 'sort_order' => 2],
            ['service_id' => 5, 'feature' => 'Body preparation', 'sort_order' => 3],
            ['service_id' => 5, 'feature' => 'Documentation assistance', 'sort_order' => 4],
            ['service_id' => 5, 'feature' => 'Cremation coordination', 'sort_order' => 1],
            ['service_id' => 5, 'feature' => 'Urn selection', 'sort_order' => 2],
            ['service_id' => 5, 'feature' => 'Memorial service planning', 'sort_order' => 3],
            ['service_id' => 5, 'feature' => 'Ash collection support', 'sort_order' => 4],
        ];

        foreach ($features as $f) {
            ServiceFeature::firstOrCreate(
                ['service_id' => $f['service_id'], 'feature' => $f['feature']],
                $f
            );
        }
    }
}
