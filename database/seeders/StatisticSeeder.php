<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['label' => 'Years of Service', 'value' => 15, 'suffix' => '+', 'sort_order' => 1, 'status' => true],
            ['label' => 'Ambulances Available', 'value' => 50, 'suffix' => '+', 'sort_order' => 2, 'status' => true],
            ['label' => 'Patients Served', 'value' => 50000, 'suffix' => '+', 'sort_order' => 3, 'status' => true],
            ['label' => 'Cities Covered', 'value' => 100, 'suffix' => '+', 'sort_order' => 4, 'status' => true],
        ];

        foreach ($stats as $s) {
            Statistic::firstOrCreate(
                ['label' => $s['label']],
                $s
            );
        }
    }
}
