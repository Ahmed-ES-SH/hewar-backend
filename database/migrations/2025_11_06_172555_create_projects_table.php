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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description'); // التفاصيل الكاملة
            $table->text('overview');    // ملخص مختصر
            $table->text('image')->nullable(); // قد يكون هناك مشاريع بدون صور
            $table->json('location');    // جيد للمرونة (مدينة, منطقة, إحداثيات...)

            // تصحيح أسماء الحقول
            $table->timestamp('start_date'); // تصحيح من start_data
            $table->timestamp('completed_at')->nullable();

            // تحسين حالة المشروع
            $table->enum('status', [
                'draft',        // مسودة
                'pending',      // في انتظار المراجعة
                'approved',     // تمت الموافقة
                'in_progress',  // قيد التنفيذ
                'completed',    // مكتمل
                'rejected',     // مرفوض
                'canceled'      // ملغي
            ])->default('draft');

            // status

            $table->json('metadata')->nullable();

            $table->integer('order')->unique();

            $table->decimal('target_amount', 12, 2)->nullable(); // المبلغ المستهدف
            $table->decimal('collected_amount', 12, 2)->default(0); // المبلغ المجموع
            $table->boolean('is_urgent')->default(false); // مشروع عاجل
            $table->integer('volunteers_needed')->nullable(); // عدد المتطوعين المطلوب

            $table->foreignId('created_by')->constrained('users', 'id')->onDelete('cascade'); // منشئ المشروع
            $table->foreignId('category_id')->constrained('project_categories', 'id')->onUpdate('cascade');
            $table->timestamps();

            $table->fullText(['title', 'description', 'overview']);

            $table->index('status');
            $table->index('category_id');
            $table->index('created_by');
            $table->index(['status', 'is_urgent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
