<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            // المعلومات الأساسية
            $table->string('title');
            $table->string('slug')->unique(); // للروابط SEO-friendly
            $table->text('content'); // محتوى المقال الكامل
            $table->text('excerpt')->nullable(); // ملخص المقال
            $table->string('image')->nullable(); // الصورة الرئيسية

            // التصنيف والتنظيم
            $table->foreignId('category_id')->nullable()->constrained('new_categories', 'id')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // كاتب المقال

            // الحالة والنشر
            $table->enum('status', [
                'draft',        // مسودة
                'under_review', // قيد المراجعة
                'published',    // منشور
                'scheduled',    // مجدول للنشر
                'rejected',     // مرفوض
                'archived'      // مؤرشف
            ])->default('draft');

            $table->timestamp('published_at')->nullable(); // تاريخ النشر الفعلي
            $table->timestamp('scheduled_for')->nullable(); // للجدولة المستقبلية

            // SEO وتحليلات
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

            $table->integer('order')->unique();

            // الإحصائيات
            $table->integer('view_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->integer('like_count')->default(0);

            // العلاقات مع المشاريع (إذا كان المقال مرتبط بمشروع خيري)
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');

            // التوقيتات
            $table->timestamps();

            // الفهارس لتحسين الأداء
            $table->index('status');
            $table->index('published_at');
            $table->index('category_id');
            $table->index('author_id');
            $table->index(['status', 'published_at']);


            $table->fullText(['title', 'excerpt', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
