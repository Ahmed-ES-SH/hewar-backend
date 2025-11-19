<?php

namespace Database\Seeders;

use App\Models\CenterMember;
use Illuminate\Database\Seeder;

class CenterMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name'        => 'Dr. Sarah Mohamed',
                'job_title'   => 'Senior Nutrition Specialist',
                'description' => 'Expert in clinical nutrition and long-term diet planning.',
                'image'       => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=60&w=500',
                'facebook'    => 'https://facebook.com/sarah',
                'instagram'   => 'https://instagram.com/sarah',
                'x'           => 'https://x.com/sarah',
                'linkedin'    => 'https://linkedin.com/in/sarah',
                'youtube'     => null,
                'whatsapp'    => null,
                'tiktok'      => null,
                'sort'        => 1,
                'is_active'   => true,
            ],

            [
                'name'        => 'Ahmed Ibrahim',
                'job_title'   => 'Physical Fitness Trainer',
                'description' => 'Certified fitness instructor specialized in body transformation.',
                'image'       => 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?q=60&w=500',
                'facebook'    => 'https://facebook.com/ahmed',
                'instagram'   => 'https://instagram.com/ahmed',
                'x'           => null,
                'linkedin'    => 'https://linkedin.com/in/ahmed',
                'youtube'     => null,
                'whatsapp'    => null,
                'tiktok'      => 'https://tiktok.com/@ahmedtrainer',
                'sort'        => 2,
                'is_active'   => true,
            ],

            [
                'name'        => 'Mona Hassan',
                'job_title'   => 'Psychological Consultant',
                'description' => 'Specialist in behavior change and motivation techniques.',
                'image'       => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=60&w=500',
                'facebook'    => null,
                'instagram'   => 'https://instagram.com/monah',
                'x'           => 'https://x.com/monah',
                'linkedin'    => 'https://linkedin.com/in/monahassan',
                'youtube'     => null,
                'whatsapp'    => null,
                'tiktok'      => null,
                'sort'        => 3,
                'is_active'   => true,
            ],

            [
                'name'        => 'Dr. Sarah Mohamed',
                'job_title'   => 'Senior Nutrition Specialist',
                'description' => 'Expert in clinical nutrition and long-term diet planning.',
                'image'       => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=60&w=500',
                'facebook'    => 'https://facebook.com/sarah',
                'instagram'   => 'https://instagram.com/sarah',
                'x'           => 'https://x.com/sarah',
                'linkedin'    => 'https://linkedin.com/in/sarah',
                'youtube'     => null,
                'whatsapp'    => null,
                'tiktok'      => null,
                'sort'        => 1,
                'is_active'   => true,
            ],

            [
                'name'        => 'Ahmed Ibrahim',
                'job_title'   => 'Physical Fitness Trainer',
                'description' => 'Certified fitness instructor specialized in body transformation.',
                'image'       => 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?q=60&w=500',
                'facebook'    => 'https://facebook.com/ahmed',
                'instagram'   => 'https://instagram.com/ahmed',
                'x'           => null,
                'linkedin'    => 'https://linkedin.com/in/ahmed',
                'youtube'     => null,
                'whatsapp'    => null,
                'tiktok'      => 'https://tiktok.com/@ahmedtrainer',
                'sort'        => 2,
                'is_active'   => true,
            ],

            [
                'name'        => 'Mona Hassan',
                'job_title'   => 'Psychological Consultant',
                'description' => 'Specialist in behavior change and motivation techniques.',
                'image'       => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=60&w=500',
                'facebook'    => null,
                'instagram'   => 'https://instagram.com/monah',
                'x'           => 'https://x.com/monah',
                'linkedin'    => 'https://linkedin.com/in/monahassan',
                'youtube'     => null,
                'whatsapp'    => null,
                'tiktok'      => null,
                'sort'        => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($members as $member) {
            CenterMember::create($member);
        }
    }
}
