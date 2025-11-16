<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'https://images.unsplash.com/photo-1603575448364-0f31b9e02b1a',
            'https://images.unsplash.com/photo-1509099836639-18ba1795216d',
            'https://images.unsplash.com/photo-1556761175-5973dc0f32e7',
            'https://images.unsplash.com/photo-1593113598332-cd6c6c69e102',
            'https://images.unsplash.com/photo-1576765607924-3e61c28e0f3f',
            'https://images.unsplash.com/photo-1532635224-3af23d105d2d',
        ];

        $categories = [1, 2, 3];
        $users = [1, 2, 3];
        $statuses = ['approved', 'in_progress', 'completed', 'pending', 'draft'];

        $projects = [
            [
                'title' => 'حملة توفير المياه للقرى الفقيرة',
                'overview' => 'مشروع لحفر آبار وتوفير مياه شرب نقية للأسر المحتاجة.',
                'description' => 'يهدف المشروع إلى حفر 5 آبار وتزويد القرى بخزانات مياه نظيفة عبر تعاون محلي ومستمر.',
                'target_amount' => 50000,
                'volunteers_needed' => 20,
                'metadata' => [
                    ['title' => ['en' => 'Wells Repaired', 'ar' => 'الآبار التي تم إصلاحها'], 'value' => 5],
                    ['title' => ['en' => 'Families Supported', 'ar' => 'الأسر المدعومة'], 'value' => 200],
                    ['title' => ['en' => 'Green Systems', 'ar' => 'الأنظمة البيئية'], 'value' => 0],
                    ['title' => ['en' => 'Children Benefiting', 'ar' => 'الأطفال المستفيدون'], 'value' => 120],
                ],
            ],
            [
                'title' => 'توزيع الحقائب المدرسية للأطفال',
                'overview' => 'مبادرة لدعم الأطفال في المدارس المحتاجة بالحقائب واللوازم الدراسية.',
                'description' => 'نهدف إلى توفير 1000 حقيبة مدرسية للأطفال قبل بداية العام الدراسي.',
                'target_amount' => 20000,
                'volunteers_needed' => 10,
                'metadata' => [
                    ['title' => ['en' => 'Families Supported', 'ar' => 'الأسر المدعومة'], 'value' => 150],
                    ['title' => ['en' => 'Children Benefiting', 'ar' => 'الأطفال المستفيدون'], 'value' => 1000],
                ],
            ],
            [
                'title' => 'بناء منازل للأسر المتضررة',
                'overview' => 'مشروع لبناء منازل بسيطة للأسر التي فقدت مأواها.',
                'description' => 'يشمل المشروع بناء 10 منازل مجهزة بكهرباء ومياه بشكل مستدام.',
                'target_amount' => 100000,
                'volunteers_needed' => 30,
                'metadata' => [
                    ['title' => ['en' => 'Families Supported', 'ar' => 'الأسر المدعومة'], 'value' => 50],
                    ['title' => ['en' => 'Green Systems', 'ar' => 'الأنظمة البيئية'], 'value' => 10],
                    ['title' => ['en' => 'Children Benefiting', 'ar' => 'الأطفال المستفيدون'], 'value' => 80],
                ],
            ],
            [
                'title' => 'وجبات غذائية للأسر المحتاجة',
                'overview' => 'توزيع سلال غذائية أسبوعية على الأسر ذات الدخل المحدود.',
                'description' => 'نوفر الوجبات عبر متطوعين بالتعاون مع مطاعم محلية.',
                'target_amount' => 15000,
                'volunteers_needed' => 8,
                'metadata' => [
                    ['title' => ['en' => 'Families Supported', 'ar' => 'الأسر المدعومة'], 'value' => 300],
                    ['title' => ['en' => 'Children Benefiting', 'ar' => 'الأطفال المستفيدون'], 'value' => 150],
                ],
            ],
            [
                'title' => 'رعاية الأيتام الشهرية',
                'overview' => 'مشروع دعم مالي وتعليمي للأيتام بشكل مستمر.',
                'description' => 'نوفر رعاية متكاملة تشمل الغذاء والتعليم والرعاية النفسية.',
                'target_amount' => 30000,
                'volunteers_needed' => 12,
                'metadata' => [
                    ['title' => ['en' => 'Families Supported', 'ar' => 'الأسر المدعومة'], 'value' => 100],
                    ['title' => ['en' => 'Children Benefiting', 'ar' => 'الأطفال المستفيدون'], 'value' => 250],
                ],
            ],
            [
                'title' => 'زراعة الأشجار في المناطق الصحراوية',
                'overview' => 'مبادرة لزراعة 5000 شجرة لتحسين المناخ المحلي.',
                'description' => 'يتم تنفيذ المشروع بالتعاون مع المدارس والبلديات المحلية.',
                'target_amount' => 25000,
                'volunteers_needed' => 15,
                'metadata' => [
                    ['title' => ['en' => 'Green Systems', 'ar' => 'الأنظمة البيئية'], 'value' => 5000],
                ],
            ],
        ];
        $order = Project::max('order') ?? 0;

        foreach ($projects as $index => $data) {
            DB::table('projects')->insert([
                'title' => $data['title'],
                'order' => $order + $index + 1,
                'slug' => Str::slug($data['title']),
                'overview' => $data['overview'],
                'description' => $data['description'],
                'image' => $images[$index % count($images)],
                'location' => json_encode([
                    'address' => 'القاهرة - مصر',
                    'lat' => 30.0444,
                    'lng' => 31.2357,
                ]),
                'start_date' => Carbon::now()->subDays(rand(10, 100)),
                'completed_at' => Carbon::now()->addDays(rand(30, 120)),
                'status' => $statuses[array_rand($statuses)],
                'target_amount' => $data['target_amount'],
                'collected_amount' => rand(1000, $data['target_amount']),
                'is_urgent' => (bool)rand(0, 1),
                'volunteers_needed' => $data['volunteers_needed'],
                'created_by' => $users[array_rand($users)],
                'category_id' => $categories[array_rand($categories)],
                'metadata' => json_encode($data['metadata'], JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
