<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AboutSeeder::class,
            ProjectCategorySeeder::class,
            ArticleCategorySeeder::class,
            NewsCategorySeeder::class,
            ProjectSeeder::class,
            ProjectImageSeeder::class,
            FooterListSeeder::class,
            TagSeeder::class,
            NewsSeeder::class,
            ArticlesTableSeeder::class,
            CharityServicesSeeder::class,
            AboutSectionSeeder::class,
            BannerSectionSeeder::class,
            HelpSectionSeeder::class,
            QuestionAnswerSectionSeeder::class,
            QuestionAnswerSeeder::class,
            CenterBranchSeeder::class,
            SocialContactInfoSeeder::class,
            CustomizeDataSeeder::class,
            CenterMemberSeeder::class,
            ContactMessagesSeeder::class,
            MemberSeeder::class,
            SliceSeeder::class,
        ]);
    }
}
