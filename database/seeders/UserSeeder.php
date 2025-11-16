<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'phone' => '+201234567890',
                'email_verification_token' => null,
                'email_verified_at' => $now,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // إضافة 9 مستخدمين عاديين
        $maleImages = [
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330',
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d',
            'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e',
        ];

        $femaleImages = [
            'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e',
            'https://images.unsplash.com/photo-1502767089025-6572583495b0',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330',
        ];

        for ($i = 1; $i <= 9; $i++) {
            $users[] = [
                'name' => fake()->name(),
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('asd'),
                'role' => 'user',
                // 'image' => $maleImages[array_rand($maleImages)],
                'phone' => '+201' . fake()->numberBetween(100000000, 999999999),
                'email_verification_token' => null,
                'email_verified_at' => fake()->boolean(80) ? fake()->dateTimeThisYear() : null,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('users')->insert($users);
    }
}
