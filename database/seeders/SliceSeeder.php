<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SliceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $imageUrls = [
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
            'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee',
            'https://images.unsplash.com/photo-1503264116251-35a269479413',
            'https://images.unsplash.com/photo-1517816428104-797678c7cf0e',
            'https://images.unsplash.com/photo-1506744038136-46273834b3fb',
        ];

        $videoLinks = [
            'https://www.youtube.com/watch?v=ysz5S6PUM-U',
            'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'https://www.youtube.com/watch?v=jNQXAC9IVRw',
            'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
            'https://www.youtube.com/watch?v=oHg5SJYRHA0',
        ];

        $slices = [];

        for ($i = 1; $i <= 5; $i++) {
            $slices[] = [
                'title_en' => "Slice Title $i",
                'title_ar' => "عنوان الشريحة رقم $i",
                'subTitle_en' => "This is the English subtitle for slice $i.",
                'subTitle_ar' => "هذا هو العنوان الفرعي للشريحة رقم $i.",
                'link_video' => $videoLinks[array_rand($videoLinks)],
                'image' => $imageUrls[array_rand($imageUrls)],
                'video_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('slices')->insert($slices);
    }
}
