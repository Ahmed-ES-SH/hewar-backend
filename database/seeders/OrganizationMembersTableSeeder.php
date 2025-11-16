<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class OrganizationMembersTableSeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على IDs المستخدمين الموجودين
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->info('No users found! Please run Users seeder first.');
            return;
        }

        $members = [
            [
                'national_id' => '1111111111',
                'position' => 'مدير المنظمة',
                'bio' => 'مدير المنظمة مع أكثر من 10 سنوات خبرة في العمل الخيري والإداري. حاصل على ماجستير في الإدارة من جامعة الملك سعود.',
                'department' => 'الإدارة',
                'employment_type' => 'full_time',
                'status' => 'active',
                'join_date' => '2020-01-15',
                'leave_date' => null,
                'social_media' => json_encode([
                    'twitter' => 'https://twitter.com/manager',
                    'linkedin' => 'https://linkedin.com/in/manager',
                    'facebook' => 'https://facebook.com/manager.profile'
                ]),
                'user_id' => $userIds[0],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '2222222222',
                'position' => 'منسق المشاريع',
                'bio' => 'منسق مشاريع متخصص في إدارة وتنفيذ المبادرات الخيرية. خبرة 5 سنوات في مجال العمل الإنساني والتنمية المجتمعية.',
                'department' => 'المشاريع',
                'employment_type' => 'full_time',
                'status' => 'active',
                'join_date' => '2021-03-20',
                'leave_date' => null,
                'social_media' => json_encode([
                    'twitter' => 'https://twitter.com/coordinator',
                    'instagram' => 'https://instagram.com/coordinator.work'
                ]),
                'user_id' => $userIds[1 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '3333333333',
                'position' => 'مطور برمجيات',
                'bio' => 'مطور برمجيات متخصص في تطوير أنظمة المنصات الخيرية. خبرة في Laravel, Vue.js, وتطوير APIs.',
                'department' => 'التقنية',
                'employment_type' => 'full_time',
                'status' => 'active',
                'join_date' => '2022-06-10',
                'leave_date' => null,
                'social_media' => json_encode([
                    'github' => 'https://github.com/developer',
                    'linkedin' => 'https://linkedin.com/in/developer',
                    'twitter' => 'https://twitter.com/dev_tech'
                ]),
                'user_id' => $userIds[2 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '4444444444',
                'position' => 'منسق تطوع',
                'bio' => 'منسق برامج التطوع مع خبرة في إدارة المتطوعين وتنظيم الفعاليات الخيرية. حاصل على شهادة في إدارة المتطوعين.',
                'department' => 'التطوع',
                'employment_type' => 'full_time',
                'status' => 'active',
                'join_date' => '2021-09-05',
                'leave_date' => null,
                'social_media' => json_encode([
                    'instagram' => 'https://instagram.com/volunteer.coord',
                    'facebook' => 'https://facebook.com/volunteer.manager'
                ]),
                'user_id' => $userIds[3 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '5555555555',
                'position' => 'متطوع نشط',
                'bio' => 'متطوع نشط في مجال العمل الخيري منذ 3 سنوات. شارك في numerous مبادرات مجتمعية وفعاليات خيرية.',
                'department' => 'التطوع',
                'employment_type' => 'volunteer',
                'status' => 'active',
                'join_date' => '2023-01-15',
                'leave_date' => null,
                'social_media' => json_encode([
                    'twitter' => 'https://twitter.com/active_volunteer'
                ]),
                'user_id' => $userIds[4 % count($userIds)],
                'can_login' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '6666666666',
                'position' => 'أخصائي تسويق',
                'bio' => 'أخصائي تسويق رقمي مع خبرة في تسويق القضايا الخيرية عبر منصات التواصل الاجتماعي.',
                'department' => 'التسويق',
                'employment_type' => 'part_time',
                'status' => 'active',
                'join_date' => '2022-11-01',
                'leave_date' => null,
                'social_media' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/marketer',
                    'instagram' => 'https://instagram.com/digital.marketer'
                ]),
                'user_id' => $userIds[5 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '7777777777',
                'position' => 'محاسب',
                'bio' => 'محاسب معتمد مع خبرة في المحاسبة للمؤسسات غير الربحية والجمعيات الخيرية.',
                'department' => 'المالية',
                'employment_type' => 'full_time',
                'status' => 'active',
                'join_date' => '2020-08-20',
                'leave_date' => null,
                'social_media' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/accountant'
                ]),
                'user_id' => $userIds[6 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '8888888888',
                'position' => 'منسق علاقات عامة',
                'bio' => 'منسق علاقات عامة مع خبرة في بناء شراكات مع المؤسسات والشركات الداعمة للعمل الخيري.',
                'department' => 'العلاقات العامة',
                'employment_type' => 'full_time',
                'status' => 'active',
                'join_date' => '2021-12-10',
                'leave_date' => null,
                'social_media' => json_encode([
                    'twitter' => 'https://twitter.com/pr_coordinator',
                    'linkedin' => 'https://linkedin.com/in/pr.professional'
                ]),
                'user_id' => $userIds[7 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '9999999999',
                'position' => 'مصمم جرافيك',
                'bio' => 'مصمم جرافيك متخصص في تصميم المواد الترويجية للحملات الخيرية والفعاليات المجتمعية.',
                'department' => 'التصميم',
                'employment_type' => 'contractor',
                'status' => 'active',
                'join_date' => '2023-03-01',
                'leave_date' => null,
                'social_media' => json_encode([
                    'behance' => 'https://behance.net/designer',
                    'instagram' => 'https://instagram.com/graphic.designer'
                ]),
                'user_id' => $userIds[8 % count($userIds)],
                'can_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'national_id' => '1010101010',
                'position' => 'باحث ميداني',
                'bio' => 'باحث ميداني متخصص في تقييم احتياجات المجتمعات وتحليل البيانات للبرامج الخيرية.',
                'department' => 'البحوث',
                'employment_type' => 'part_time',
                'status' => 'inactive',
                'join_date' => '2022-02-15',
                'leave_date' => '2023-12-01',
                'social_media' => json_encode([]),
                'user_id' => $userIds[9 % count($userIds)],
                'can_login' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('organization_members')->insert($members);

        $this->command->info('Organization members seeded successfully!');
        $this->command->info('Total members: ' . count($members));
    }
}
