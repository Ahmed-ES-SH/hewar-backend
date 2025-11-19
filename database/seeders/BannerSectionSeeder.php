<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cards = [
            [
                "icon" => "FaDoorOpen",
                "color" => "text-blue-500",
                "bg" => "bg-light-primary-color",
                "title" => [
                    "ar" => "مفتوح دائمًا",
                    "en" => "Always Open",
                ],
                "description" => [
                    "ar" => "نرحّب بالجميع في أي وقت دون قيود أو مواعيد.",
                    "en" => "We welcome everyone at any time without restrictions or appointments.",
                ],
                "textColor" => "text-gray-100",
            ],
            [
                "icon" => "FaUsers",
                "color" => "text-green-500",
                "bg" => "bg-white",
                "title" => [
                    "ar" => "عدد أكبر من الأشخاص",
                    "en" => "More People",
                ],
                "description" => [
                    "ar" => "نزيد من تأثيرنا من خلال خدمة عدد أكبر من المستفيدين.",
                    "en" => "We increase our impact by serving more beneficiaries.",
                ],
                "textColor" => "text-gray-800",
            ],
            [
                "icon" => "FaHandsHelping",
                "color" => "text-orange-500",
                "bg" => "bg-white",
                "title" => [
                    "ar" => "ندعم بعضنا البعض",
                    "en" => "Support Each Other",
                ],
                "description" => [
                    "ar" => "نعمل معًا لتقديم المساعدة لكل من يحتاجها.",
                    "en" => "We work together to support anyone in need.",
                ],
                "textColor" => "text-gray-800",
            ],
        ];


        $HeadData = [
            "title" => [
                'en' => 'Our Door Are Always Open To More People Who Want To Support Each Others!',
                'ar' => 'بابنا مفتوح دائمًا لمزيد من الأشخاص الذين يرغبون في دعم بعضهم البعض!'
            ],
            "icon" => 'FaDoorOpen'
        ];

        DB::table('variable_data')->updateOrInsert(
            ['id' => 2], // يمكن تغييره حسب الحالة
            [
                'column_4' => json_encode($cards, JSON_UNESCAPED_UNICODE),
                'column_5' => json_encode($HeadData, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
