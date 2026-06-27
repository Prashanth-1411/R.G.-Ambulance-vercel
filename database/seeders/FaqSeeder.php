<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question' => 'How quickly can you respond to an emergency call?', 'answer' => 'Our average response time is under 15 minutes within city limits. We maintain strategically positioned ambulances to ensure rapid deployment 24 hours a day, 7 days a week.'],
            ['question' => 'What types of ambulance services do you offer?', 'answer' => 'We provide Basic Life Support (BLS), Advanced Life Support (ALS), ICU transport, neonatal transport, air ambulance coordination, and non-emergency patient transfer services.'],
            ['question' => 'Do you provide inter-city or inter-state transport?', 'answer' => 'Yes, we offer long-distance patient transport with fully equipped ambulances and trained medical staff accompanying the patient throughout the journey.'],
            ['question' => 'What medical equipment is available in your ambulances?', 'answer' => 'Our fleet includes cardiac monitors, defibrillators, ventilators, infusion pumps, oxygen systems, spine boards, and a complete range of emergency medications.'],
            ['question' => 'How do I book a non-emergency transport?', 'answer' => 'You can book through our website contact form, call our 24/7 helpline, or send a WhatsApp message. We recommend booking at least 24 hours in advance for scheduled transfers.'],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, [
                    'category' => 'general',
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ])
            );
        }
    }
}
