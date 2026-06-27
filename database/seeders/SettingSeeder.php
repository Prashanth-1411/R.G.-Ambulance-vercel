<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(
            ['company_name' => 'R.G. Ambulance Service'],
            [
            'company_name' => 'R.G. Ambulance Service',
            'tagline' => 'Your Trusted Emergency Medical Transport Service',
            'email' => 'info@rgambulanceservice.com',
            'phone_primary' => '+91-9876543210',
            'phone_secondary' => '+91-9876543211',
            'phone_office' => '+91-1800-123-456',
            'whatsapp' => '+91-9876543210',
            'address' => '123, Healthcare Complex, Main Road',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'established_year' => '2010',
            'iso_certified' => true,
            'facebook' => 'https://facebook.com/rgambulance',
            'twitter' => 'https://twitter.com/rgambulance',
            'instagram' => 'https://instagram.com/rgambulance',
            'linkedin' => 'https://linkedin.com/company/rgambulance',
            'youtube' => 'https://youtube.com/@rgambulance',
        ]);
    }
}
