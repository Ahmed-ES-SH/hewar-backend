<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $charities = [
            [
                'icon'  => 'FaUtensils',
                'text'  => [
                    'ar' => 'تبرعات الطعام',
                    'en' => 'Charity For Food',
                ],
                'color' => 'bg-teal-600',
                'delay' => 0.2,
            ],
            [
                'icon'  => 'FaTint',
                'text'  => [
                    'ar' => 'تبرعات المياه',
                    'en' => 'Charity For Water',
                ],
                'color' => 'bg-yellow-500',
                'delay' => 0.3,
            ],
            [
                'icon'  => 'FaGraduationCap',
                'text'  => [
                    'ar' => 'الدعم التعليمي',
                    'en' => 'Charity For Education',
                ],
                'color' => 'bg-orange-500',
                'delay' => 0.4,
            ],
            [
                'icon'  => 'FaHeartbeat',
                'text'  => [
                    'ar' => 'الرعاية الطبية',
                    'en' => 'Charity For Medical',
                ],
                'color' => 'bg-teal-700',
                'delay' => 0.5,
            ],
        ];

        $texts = [
            'badge' => [
                'en' => 'About Us',
                'ar' => 'معلومات عنا',
            ],
            'title' => [
                'en' => 'Donat',
                'ar' => 'التبرع',
            ],
            'heading' => [
                'en' => "We Believe That We Can Save More Life's With You",
                'ar' => 'نؤمن بأننا نستطيع إنقاذ المزيد من الأرواح معك',
            ],
            'description' => [
                'en' => "Dialogue and Civil Peace Center is the largest global crowdfunding community connecting nonprofits, donors, and companies in nearly every country. We help nonprofits from Afghanistan to Zimbabwe (and hundreds of places in between) access the tools, training, and support they need to be more effective and make our world a better place.",
                'ar' => "مركز الحوار والسلم الأهلي هو أكبر مجتمع للتمويل الجماعي العالمي يربط المنظمات غير الربحية والمانحين والشركات في كل بلد تقريبًا. نحن نساعد المنظمات غير الربحية من أفغانستان إلى زيمبابوي (ومئات الأماكن بينهما) في الوصول إلى الأدوات والتدريب والدعم التي تحتاجها لتكون أكثر فعالية وجعل عالمنا مكانًا أفضل.",
            ],
        ];

        $mainImage = '/website/about_1_1-2.png';


        DB::table('variable_data')->updateOrInsert(
            ['id' => 2], // يمكن تغييره حسب الحالة
            [
                'column_1' => json_encode($charities, JSON_UNESCAPED_UNICODE),
                'column_2' => json_encode($texts, JSON_UNESCAPED_UNICODE),
                'column_3' => json_encode($mainImage),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
