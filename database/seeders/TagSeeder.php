<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // ==== Article Tags ====
            ['name' => 'Technology', 'type' => 'article'],
            ['name' => 'Health', 'type' => 'article'],
            ['name' => 'Education', 'type' => 'article'],
            ['name' => 'Culture', 'type' => 'article'],
            ['name' => 'Sports', 'type' => 'article'],

            // ==== News Tags ====
            ['name' => 'Breaking News', 'type' => 'news'],
            ['name' => 'Politics', 'type' => 'news'],
            ['name' => 'Economy', 'type' => 'news'],
            ['name' => 'Environment', 'type' => 'news'],
            ['name' => 'World', 'type' => 'news'],

            // ==== Project Tags ====
            ['name' => 'Charity', 'type' => 'project'],
            ['name' => 'Education Support', 'type' => 'project'],
            ['name' => 'Health Aid', 'type' => 'project'],
            ['name' => 'Community Development', 'type' => 'project'],
            ['name' => 'Urgent Relief', 'type' => 'project'],
        ];

        // إضافة slug وتواريخ الإنشاء دفعة واحدة
        $data = collect($tags)->map(function ($tag) {
            return [
                'name'       => $tag['name'],
                'slug'       => Str::slug($tag['name']),
                'type'       => $tag['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        // إدخال البيانات دفعة واحدة لسرعة وأداء أفضل
        DB::table('tags')->insert($data);
    }
}
