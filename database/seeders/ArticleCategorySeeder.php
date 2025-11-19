<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            [
                'title_en' => 'Community Stories',
                'title_ar' => 'قصص المجتمع',
                'icon_name' => 'FaUsers',
                'bg_color' => '#2563EB',
                'image' => 'https://images.unsplash.com/photo-1531379410502-63bfe8cdaf6f',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Volunteer Insights',
                'title_ar' => 'رؤى المتطوعين',
                'icon_name' => 'FaHandsHelping',
                'bg_color' => '#10B981',
                'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Health Awareness',
                'title_ar' => 'التوعية الصحية',
                'icon_name' => 'FaHeartbeat',
                'bg_color' => '#EF4444',
                'image' => 'https://images.unsplash.com/photo-1587502536263-1a456d7d9b37',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Education & Learning',
                'title_ar' => 'التعليم والتعلم',
                'icon_name' => 'FaBookOpen',
                'bg_color' => '#F59E0B',
                'image' => 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Environmental Care',
                'title_ar' => 'العناية بالبيئة',
                'icon_name' => 'FaLeaf',
                'bg_color' => '#16A34A',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('article_categories')->insert($categories);
    }
}
