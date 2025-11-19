<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Project;

class ProjectImageSeeder extends Seeder
{
    public function run(): void
    {
        // مجموعة صور من Unsplash سيتم تكرارها عشوائياً
        $images = [
            'https://images.unsplash.com/photo-1603575448364-0f31b9e02b1a',
            'https://images.unsplash.com/photo-1556761175-5973dc0f32e7',
            'https://images.unsplash.com/photo-1593113598332-cd6c6c69e102',
            'https://images.unsplash.com/photo-1576765607924-3e61c28e0f3f',
            'https://images.unsplash.com/photo-1532635224-3af23d105d2d',
            'https://images.unsplash.com/photo-1509099836639-18ba1795216d',
            'https://images.unsplash.com/photo-1603575448364-0f31b9e02b1a',
            'https://images.unsplash.com/photo-1581090700227-1e37b190418e',
            'https://images.unsplash.com/photo-1526256262350-7da7584cf5eb',
            'https://images.unsplash.com/photo-1567428485548-1a9c0a19d4d9',
        ];

        $projects = Project::all();

        foreach ($projects as $project) {
            // اختيار 4 صور عشوائية من القائمة
            $selected = Arr::random($images, 4);

            foreach ($selected as $url) {
                DB::table('project_images')->insert([
                    'project_id' => $project->id,
                    'image_path' => $url,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
