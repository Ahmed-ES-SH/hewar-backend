<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CenterBranch;

class CenterBranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'email' => 'branch1@example.com',
                'phone' => '01000000001',
                'location' => [
                    'address' => 'شارع التحرير - القاهرة',
                    'lat' => 30.0444,
                    'lng' => 31.2357,
                ],
            ],
            [
                'email' => 'branch2@example.com',
                'phone' => '01000000002',
                'location' => [
                    'address' => 'شارع البحر - الإسكندرية',
                    'lat' => 31.2001,
                    'lng' => 29.9187,
                ],
            ],
            [
                'email' => 'branch3@example.com',
                'phone' => '01000000003',
                'location' => [
                    'address' => 'شارع الجيش - طنطا',
                    'lat' => 30.7917,
                    'lng' => 31.0030,
                ],
            ],
            [
                'email' => 'branch4@example.com',
                'phone' => '01000000004',
                'location' => [
                    'address' => 'شارع الهرم - الجيزة',
                    'lat' => 29.9873,
                    'lng' => 31.2118,
                ],
            ],
            [
                'email' => 'branch5@example.com',
                'phone' => '01000000005',
                'location' => [
                    'address' => 'شارع النصر - المنصورة',
                    'lat' => 31.0409,
                    'lng' => 31.3785,
                ],
            ],
        ];

        foreach ($branches as $branch) {
            CenterBranch::create($branch);
        }
    }
}
