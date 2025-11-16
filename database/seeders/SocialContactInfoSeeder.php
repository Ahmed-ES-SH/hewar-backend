<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialAccount;

class SocialContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إدراج بيانات افتراضية لحسابات التواصل الاجتماعي الخاصة بالشركة
        SocialAccount::updateOrCreate(
            ['id' => 1], // تحديد السجل الأول
            [
                'whatsapp_number' => '+201234567890',
                'gmail_account' => 'company@gmail.com',
                'facebook_account' => 'https://www.facebook.com/company',
                'x_account' => 'https://twitter.com/company',
                'youtube_account' => 'https://www.youtube.com/company',
                'instgram_account' => 'https://www.instagram.com/company',
                'snapchat_account' => 'https://www.snapchat.com/add/company',
                'tiktok_account' => 'https://www.tiktok.com/add/company',
                'linked_account' => 'https://www.linkedin.com/company',
                'location' => [
                    'address' => 'وسط مدينة دمشق - سوريا',
                    'lat' => 33.5138, // خط عرض دمشق
                    'lng' => 36.2765, // خط طول دمشق
                ]
            ]
        );
    }
}
