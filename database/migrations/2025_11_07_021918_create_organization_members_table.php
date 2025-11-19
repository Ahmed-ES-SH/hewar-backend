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
        Schema::create('organization_members', function (Blueprint $table) {
            $table->id();

            // المعلومات الشخصية
            $table->string('national_id')->unique()->nullable();

            // المعلومات المهنية
            $table->string('position');
            $table->text('bio')->nullable();
            $table->string('department')->nullable();
            $table->enum('employment_type', [
                'full_time',
                'part_time',
                'volunteer',
                'contractor'
            ])->default('full_time');

            // الحالة والنظام
            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'on_leave'
            ])->default('active');

            $table->date('join_date')->nullable();
            $table->date('leave_date')->nullable();

            // وسائل التواصل الاجتماعي (تخزين في JSON)
            $table->json('social_media')->nullable();

            // العلاقات
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // الأمان والصلاحيات
            $table->boolean('can_login')->default(false);

            $table->timestamps();

            // الفهارس
            $table->index('status');
            $table->index('position');
            $table->index('department');
            $table->index('employment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_members');
    }
};
