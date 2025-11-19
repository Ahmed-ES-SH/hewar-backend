<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            [
                'title_en' => 'Local News',
                'title_ar' => 'الأخبار المحلية',
                'icon_name' => 'FaMapMarkerAlt',
                'bg_color' => '#3B82F6',
                'image' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Global News',
                'title_ar' => 'الأخبار العالمية',
                'icon_name' => 'FaGlobe',
                'bg_color' => '#10B981',
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Charity Activities',
                'title_ar' => 'أنشطة الجمعية',
                'icon_name' => 'FaHandsHelping',
                'bg_color' => '#F97316',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Emergency Updates',
                'title_ar' => 'تحديثات الطوارئ',
                'icon_name' => 'FaExclamationTriangle',
                'bg_color' => '#DC2626',
                'image' => 'https://images.unsplash.com/photo-1581090700227-1e37b190418e',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Success Stories',
                'title_ar' => 'قصص النجاح',
                'icon_name' => 'FaStar',
                'bg_color' => '#EAB308',
                'image' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('new_categories')->insert($categories);
    }
}
