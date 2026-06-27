<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $certificates = [
            ['title' => 'ISO 9001:2015 Certified', 'issuer' => 'International Standards Organization', 'type' => 'certificate', 'sort_order' => 1, 'status' => true],
            ['title' => 'Best Emergency Service Provider 2023', 'issuer' => 'Healthcare Excellence Awards', 'type' => 'award', 'sort_order' => 2, 'status' => true],
            ['title' => 'NABH Accreditation', 'issuer' => 'National Accreditation Board for Hospitals', 'type' => 'certificate', 'sort_order' => 3, 'status' => true],
        ];

        foreach ($certificates as $c) {
            Certificate::firstOrCreate(
                ['title' => $c['title']],
                $c
            );
        }
    }
}
