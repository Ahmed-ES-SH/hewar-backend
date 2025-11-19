<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharityServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'icon' => 'FcElectricalSensor',
                'icon_style' => 'size-12',
                'title' => [
                    'en' => 'Electrical Inspections',
                    'ar' => 'فحوصات كهربائية',
                ],
                'description' => [
                    'en' => 'Share stories and experiences from volunteers to inspire others to join.',
                    'ar' => 'شارك القصص والتجارب من المتطوعين لإلهام الآخرين للانضمام.',
                ],
            ],
            [
                'icon' => 'FaGraduationCap',
                'icon_style' => 'text-green-600 size-12',
                'title' => [
                    'en' => 'Educations',
                    'ar' => 'التعليم',
                ],
                'description' => [
                    'en' => 'Discover impactful projects and ways to help others thrive.',
                    'ar' => 'استكشف المشاريع التعليمية والطرق لمساعدة الآخرين على التقدم.',
                ],
            ],
            [
                'icon' => 'FaHeartbeat',
                'icon_style' => 'size-12 text-red-500',
                'title' => [
                    'en' => 'Medical Help',
                    'ar' => 'المساعدة الطبية',
                ],
                'description' => [
                    'en' => 'Connect with donation options and inspiring health stories.',
                    'ar' => 'تواصل مع خيارات التبرع وقصص ملهمة في مجال الصحة.',
                ],
            ],
        ];


        $mainTitles =
            [
                'title' => [
                    'en' => 'We Do It For All People Humanist Services',
                    'ar' => 'نحن نفعل ذلك لجميع الناس الخدمات الإنسانية',
                ],
                'subtitle' => [
                    'en' => 'Charity Services',
                    'ar' => 'الخدمات الخيرية',
                ],
            ];

        DB::table('variable_data')->updateOrInsert(
            ['id' => 1], // يمكن تغييره حسب الحالة
            [
                'column_1' => json_encode($services, JSON_UNESCAPED_UNICODE),
                'column_2' => json_encode($mainTitles, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
