<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionAnswerSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $texts = [
            'title' => ['en' => "Frequently Asked Questions", "ar" => 'الأسئلة الشائعة'],
            'heading' => ['en' => "Have Any Questions For Us?", "ar" => 'هل لديك أي أسئلة لنا؟'],
            'footer' => ['en' => "Join us in making a difference", "ar" => 'انضم إلينا في إحداث فرق']
        ];


        $images = [
            "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&q=80",
            "https://images.unsplash.com/photo-1593113646773-028c64a8f1b8?w=800&q=80",
            "/website/hand-group-shape1-3-1.png",
        ];

        $contactImage = "/website/contact-1.png";

        DB::table('variable_data')->updateOrInsert(
            ['id' => 4], // يمكن تغييره حسب الحالة
            [
                'column_1' => json_encode($texts, JSON_UNESCAPED_UNICODE),
                'column_2' => $images[0],
                'column_3' => $images[1],
                'column_4' => $images[2],
                // add the contant image too , i wan`t make file for this simple thing
                'column_5' => $contactImage,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
