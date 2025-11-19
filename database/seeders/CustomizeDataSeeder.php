<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomizeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variable_data')->updateOrInsert(
            ['id' => 5], // يمكن تغييره حسب الحالة
            [
                'column_1' => '/logo.png',
                'column_2' => '#3b9797',
                'column_3' => '#4a9782',
                'column_4' => [
                    "en" => "Welcome to CDCD Are you ready to help them? Let’s become avolunteers...",
                    "ar" => "أهلاً بكم في CDCD. هل أنتم مستعدون لمساعدتهم؟ هيا بنا نصبح متطوعين..."
                ],
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
