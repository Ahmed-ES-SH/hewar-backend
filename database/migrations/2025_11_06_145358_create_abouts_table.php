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

        Schema::create('abouts', function (Blueprint $table) {
            $table->id();

            // عناوين الأقسام
            $table->string('first_section_title_ar')->nullable();
            $table->string('first_section_title_en')->nullable();
            $table->string('second_section_title_ar')->nullable();
            $table->string('second_section_title_en')->nullable();
            $table->string('third_section_title_ar')->nullable();
            $table->string('third_section_title_en')->nullable();
            $table->string('fourth_section_title_ar')->nullable();
            $table->string('fourth_section_title_en')->nullable();

            // المحتوى النصي للأقسام
            $table->text('first_section_content_ar')->nullable();
            $table->text('first_section_content_en')->nullable();
            $table->text('second_section_content_ar')->nullable();
            $table->text('second_section_content_en')->nullable();
            $table->text('third_section_content_ar')->nullable();
            $table->text('third_section_content_en')->nullable();
            $table->text('fourth_section_content_ar')->nullable();
            $table->text('fourth_section_content_en')->nullable();

            // خيارات إضافية
            $table->boolean('show_map')->nullable();
            $table->string('address')->nullable();

            // صور الأقسام
            $table->string('first_section_image')->nullable();
            $table->string('second_section_image')->nullable();
            $table->string('third_section_image')->nullable();
            $table->string('fourth_section_image')->nullable();

            // فيديوهات
            $table->text('main_video')->nullable();
            $table->text('link_video')->nullable();

            // معلومات الدفع
            $table->text('qr_path')->nullable();
            $table->string('merchant_phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
