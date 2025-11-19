<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $stats = [
            [
                "value" => "15K+",
                "title" => [
                    "ar" => "المتطوعون",
                    "en" => "Volunteers",
                ],
            ],
            [
                "value" => "1K+",
                "title" => [
                    "ar" => "الحملات",
                    "en" => "Campaigns",
                ],
            ],
            [
                "value" => "400+",
                "title" => [
                    "ar" => "المانحون",
                    "en" => "Donors",
                ],
            ],
            [
                "value" => "35K+",
                "title" => [
                    "ar" => "الدعم",
                    "en" => "Support",
                ],
            ],
        ];


        $headData = [
            'title' => ["ar" => "نحن نساعد دائمًا الأشخاص المحتاجين", "en" => "We Always Help The Needy People"],
            'description' => ["ar" => "اكتشف القصص الملهمة للأفراد والمجتمعات التي غيّرتها برامجنا. تُسلّط قصص نجاحنا الضوء على الأثر الحقيقي لتبرعاتكم.", "en" => "Discover the inspiring stories of individuals and communities transformed by our programs. Our success stories highlight the real-life impact of your donations."],
        ];

        $imageSrc = "http://127.0.0.1:8000/images/variablesData/Screenshot 2025-10-30 123654_691733a47ae12.png";
        $VideoSrc = "http://127.0.0.1:8000/images/variablesData/AQOuM9TxIh4bWLnpZSs97kH4CcRO6zHSQynCbKc_rBWRFrvTVWaz2huphO7AlL2E3JRPD3gjS62XKI4mZfk2pk473gZJ0LrfWkUezPKCvLrWZQ_691733a47b902.mp4";

        DB::table('variable_data')->updateOrInsert(
            ['id' => 3], // يمكن تغييره حسب الحالة
            [
                'column_1' => json_encode($headData, JSON_UNESCAPED_UNICODE),
                'column_2' => json_encode($stats, JSON_UNESCAPED_UNICODE),
                'column_3' => $imageSrc,
                'column_4' => $VideoSrc,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
