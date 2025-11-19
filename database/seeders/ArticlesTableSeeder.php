<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'أهمية العمل الخيري في بناء المجتمعات',
                'content' => 'العمل الخيري يمثل ركيزة أساسية في بناء المجتمعات المتماسكة. من خلال المبادرات الخيرية، يمكننا مساعدة المحتاجين وتقديم الدعم للأسر المتعففة. هذا المقال يسلط الضوء على أثر العمل الخيري في تنمية المجتمع.',
                'excerpt' => 'استكشف كيف يمكن للعمل الخيري أن يحدث فرقاً حقيقياً في حياة الأفراد والمجتمعات.',
                'category_id' => 1,
                'author_id' => 1,
                'order' => 1,
                'status' => 'published',
                'published_at' => now(),
                'meta_title' => 'أهمية العمل الخيري في بناء المجتمعات',
                'meta_description' => 'مقال عن دور العمل الخيري في تنمية المجتمعات ومساعدة المحتاجين',
                'image' => 'https://images.unsplash.com/photo-1559028012-481c04fa702d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'كيفية التطوع في المشاريع الخيرية',
                'content' => 'التطوع في المشاريع الخيرية ليس مجرد عمل إنساني، بل هو فرصة للتعلم وتطوير المهارات. في هذا المقال، سنستعرض أفضل الطرق للبدء في التطوع وكيفية اختيار المشاريع المناسبة لمهاراتك واهتماماتك.',
                'excerpt' => 'دليل شامل للتطوع في المشاريع الخيرية وكيفية اختيار الفرص المناسبة.',
                'category_id' => 2,
                'author_id' => 1,
                'order' => 2,
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'meta_title' => 'كيفية التطوع في المشاريع الخيرية',
                'meta_description' => 'دليل شامل للتطوع في المشاريع الخيرية واختيار الفرص المناسبة',
                'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'تأثير الصدقة على الفرد والمجتمع',
                'content' => 'الصدقة لها تأثير إيجابي كبير على كل من المتبرع والمستفيد. هذا المقال يتناول الفوائد النفسية والاجتماعية للصدقة، وكيف يمكن للعطاء أن يحسن من جودة الحياة للجميع.',
                'excerpt' => 'اكتشف الفوائد المذهلة للصدقة على المستوى الشخصي والمجتمعي.',
                'category_id' => 1,
                'author_id' => 1,
                'order' => 3,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'meta_title' => 'تأثير الصدقة على الفرد والمجتمع',
                'meta_description' => 'مقال عن الفوائد النفسية والاجتماعية للصدقة',
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18861754?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'مشاريع التنمية المستدامة في العمل الخيري',
                'content' => 'تحول العمل الخيري من تقديم المساعدات العاجلة إلى تنفيذ مشاريع تنموية مستدامة. نستعرض في هذا المقال أهم مشاريع التنمية المستدامة وكيفية تحقيق تأثير طويل الأمد.',
                'excerpt' => 'كيف يمكن تحويل المساعدات الخيرية إلى مشاريع تنموية مستدامة.',
                'category_id' => 3,
                'author_id' => 1,
                'order' => 4,
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'meta_title' => 'مشاريع التنمية المستدامة في العمل الخيري',
                'meta_description' => 'مقال عن مشاريع التنمية المستدامة في المجال الخيري',
                'image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'دور التكنولوجيا في تعزيز العمل الخيري',
                'content' => 'مع تطور التكنولوجيا، أصبحت المنصات الخيرية أكثر فعالية في الوصول إلى المحتاجين وزيادة الشفافية. نناقش في هذا المقال أحدث التقنيات المستخدمة في العمل الخيري.',
                'excerpt' => 'كيف تساهم التكنولوجيا في تطوير العمل الخيري وزيادة الشفافية.',
                'category_id' => 4,
                'author_id' => 1,
                'order' => 5,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'meta_title' => 'دور التكنولوجيا في تعزيز العمل الخيري',
                'meta_description' => 'مقال عن استخدام التكنولوجيا في تحسين العمل الخيري',
                'image' => 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'قصص نجاح: كيف غيرت المنح الدراسية حياة الطلاب',
                'content' => 'من خلال سلسلة من القصص الواقعية، نستعرض كيف ساهمت المنح الدراسية في تغيير حياة الطلاب المحتاجين وتمكينهم من تحقيق أحلامهم الأكاديمية والمهنية.',
                'excerpt' => 'قصص ملهمة لطلاب استفادوا من المنح الدراسية الخيرية.',
                'category_id' => 5,
                'author_id' => 1,
                'order' => 6,
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'meta_title' => 'قصص نجاح: كيف غيرت المنح الدراسية حياة الطلاب',
                'meta_description' => 'قصص واقعية عن تأثير المنح الدراسية على حياة الطلاب',
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'كيفية إنشاء مشروع خيري ناجح',
                'content' => 'إنشاء مشروع خيري ناجح يتطلب تخطيطاً دقيقاً وفهماً عميقاً لاحتياجات المجتمع. نقدم في هذا المقال دليلاً شاملاً لإنشاء وإدارة المشاريع الخيرية بشكل فعال.',
                'excerpt' => 'دليل عملي لإنشاء وإدارة المشاريع الخيرية بنجاح.',
                'category_id' => 3,
                'author_id' => 1,
                'order' => 7,
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'meta_title' => 'كيفية إنشاء مشروع خيري ناجح',
                'meta_description' => 'دليل شامل لإنشاء وإدارة المشاريع الخيرية',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'أهمية الشفافية في جمع التبرعات',
                'content' => 'الشفافية هي أساس ثقة المتبرعين في المؤسسات الخيرية. نناقش في هذا المقال معايير الشفافية المالية والإدارية وكيفية تطبيقها في المؤسسات الخيرية.',
                'excerpt' => 'لماذا تعتبر الشفافية أساسية لنجاح المؤسسات الخيرية.',
                'category_id' => 2,
                'author_id' => 1,
                'order' => 8,
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'meta_title' => 'أهمية الشفافية في جمع التبرعات',
                'meta_description' => 'مقال عن معايير الشفافية في المؤسسات الخيرية',
                'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'برامج الرعاية الصحية في المجتمعات المحتاجة',
                'content' => 'تسليط الضوء على أهمية برامج الرعاية الصحية وكيف تساهم المؤسسات الخيرية في تقديم خدمات طبية للمجتمعات المحرومة من الخدمات الأساسية.',
                'excerpt' => 'دور المؤسسات الخيرية في تقديم الرعاية الصحية للمجتمعات المحتاجة.',
                'category_id' => 1,
                'author_id' => 1,
                'order' => 9,
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'meta_title' => 'برامج الرعاية الصحية في المجتمعات المحتاجة',
                'meta_description' => 'مقال عن برامج الرعاية الصحية الخيرية',
                'image' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'تأثير الأزمات الإنسانية وكيفية الاستجابة',
                'content' => 'في ظل تزايد الأزمات الإنسانية حول العالم، نستعرض استراتيجيات الاستجابة الفعالة وأفضل الممارسات في تقديم المساعدات العاجلة للمتضررين.',
                'excerpt' => 'دليل للاستجابة الفعالة في حالات الأزمات الإنسانية.',
                'category_id' => 3,
                'author_id' => 1,
                'order' => 10,
                'status' => 'published',
                'published_at' => now()->subDays(25),
                'meta_title' => 'تأثير الأزمات الإنسانية وكيفية الاستجابة',
                'meta_description' => 'مقال عن استراتيجيات الاستجابة للأزمات الإنسانية',
                'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ]
        ];

        foreach ($articles as $article) {
            // إنشاء slug من العنوان
            $article['slug'] = Str::slug($article['title']);

            // إضافة الحقول الإضافية
            $article['meta_keywords'] = json_encode(['خير', 'تطوع', 'مجتمع']);
            $article['view_count'] = rand(100, 1000);
            $article['share_count'] = rand(10, 100);
            $article['like_count'] = rand(50, 200);
            $article['created_at'] = now();
            $article['updated_at'] = now();

            DB::table('articles')->insert($article);
        }
    }
}
