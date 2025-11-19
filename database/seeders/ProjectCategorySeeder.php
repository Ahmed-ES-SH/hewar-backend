<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            [
                'title_en' => 'Education',
                'title_ar' => 'التعليم',
                'icon_name' => 'FaGraduationCap',
                'bg_color' => '#3B82F6',
                'image' => 'https://images.unsplash.com/photo-1588072432836-e10032774350',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Health',
                'title_ar' => 'الصحة',
                'icon_name' => 'FaHeartbeat',
                'bg_color' => '#EF4444',
                'image' => 'https://images.unsplash.com/photo-1588776814546-ec7c0e1eac60',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Water & Sanitation',
                'title_ar' => 'المياه والصرف الصحي',
                'icon_name' => 'FaTint',
                'bg_color' => '#0EA5E9',
                'image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Food Aid',
                'title_ar' => 'المساعدات الغذائية',
                'icon_name' => 'FaUtensils',
                'bg_color' => '#F97316',
                'image' => 'https://images.unsplash.com/photo-1600891963935-9053c2c7e1d1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Orphans Support',
                'title_ar' => 'رعاية الأيتام',
                'icon_name' => 'FaChild',
                'bg_color' => '#8B5CF6',
                'image' => 'https://images.unsplash.com/photo-1559027615-5da2a9f06e4b',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Environment',
                'title_ar' => 'البيئة',
                'icon_name' => 'FaLeaf',
                'bg_color' => '#10B981',
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Housing',
                'title_ar' => 'الإسكان والملاجئ',
                'icon_name' => 'FaHome',
                'bg_color' => '#F59E0B',
                'image' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Emergency Relief',
                'title_ar' => 'الإغاثة الطارئة',
                'icon_name' => 'FaLifeRing',
                'bg_color' => '#DC2626',
                'image' => 'https://images.unsplash.com/photo-1581091012184-5c7b5b6f75c0',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Economic Empowerment',
                'title_ar' => 'التمكين الاقتصادي',
                'icon_name' => 'FaBriefcase',
                'bg_color' => '#16A34A',
                'image' => 'https://images.unsplash.com/photo-1565514158740-064f34bd6b8f',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Volunteering',
                'title_ar' => 'التطوع والخدمة المجتمعية',
                'icon_name' => 'FaHandsHelping',
                'bg_color' => '#EC4899',
                'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('project_categories')->insert($categories);
    }
}
