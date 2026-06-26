<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'page_name' => 'home',
                'heading' => 'Home',
                'subheading' => 'Your Trusted Emergency Medical & Funeral Service Partner',
                'content' => 'R.G. Ambulance Service is a premier provider of emergency medical transport and dignified funeral services across India. Since 2010, we have been serving communities with a modern fleet of Advanced Life Support ambulances, ICU-equipped mobile units, and premium funeral vehicles. Our team of certified paramedics, EMTs, and compassionate support staff works round the clock to ensure that every journey — whether saving a life or honouring a loved one — is handled with the highest standards of care, respect, and professionalism.',
                'status' => true,
            ],
            [
                'page_name' => 'about',
                'heading' => 'About Us',
                'subheading' => 'Leading Ambulance & Funeral Service Since 2010',
                'content' => 'R.G. Ambulance Service has been a trusted name in emergency medical transport and dignified funeral services since 2010. With a fleet of modern Advanced Life Support ambulances, ICU-equipped mobile units, premium funeral hearses, and temperature-controlled mortuary vans, we serve over 50,000 families across 100+ cities. Our team of certified paramedics, EMTs, and compassionate funeral care staff works 24/7 to ensure every critical moment is handled with speed, professionalism, and respect.',
                'status' => true,
            ],
            [
                'page_name' => 'services',
                'heading' => 'Our Services',
                'subheading' => 'Comprehensive Emergency & Funeral Services',
                'content' => 'We offer a wide range of services including Basic Life Support (BLS) ambulances, Advanced Life Support (ALS) ambulances, patient transport services, funeral transport, mortuary services, and cremation assistance. Each service is delivered with the highest standards of safety, dignity, and professionalism.',
                'status' => true,
            ],
            [
                'page_name' => 'contact',
                'heading' => 'Contact Us',
                'subheading' => 'Get In Touch',
                'content' => 'We are available 24/7 to assist you. Whether you need emergency medical transport, have questions about our services, or want to provide feedback, our team is ready to help. Reach out to us via phone, email, or visit our office.',
                'status' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(['page_name' => $page['page_name']], $page);
        }
    }
}
