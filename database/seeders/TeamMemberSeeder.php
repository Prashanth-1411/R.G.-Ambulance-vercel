<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Dr. Rajesh Gupta', 'designation' => 'Medical Director', 'sort_order' => 1, 'status' => true],
            ['name' => 'Suresh Patel', 'designation' => 'Operations Manager', 'sort_order' => 2, 'status' => true],
            ['name' => 'Priya Sharma', 'designation' => 'Head Paramedic', 'sort_order' => 3, 'status' => true],
            ['name' => 'Amit Kumar', 'designation' => 'Fleet Manager', 'sort_order' => 4, 'status' => true],
        ];

        foreach ($members as $m) {
            TeamMember::firstOrCreate(
                ['name' => $m['name']],
                $m
            );
        }
    }
}
