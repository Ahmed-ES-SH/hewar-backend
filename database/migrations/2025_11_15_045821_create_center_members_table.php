<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('center_members', function (Blueprint $table) {
            $table->id();

            // Basic info (single language)
            $table->string('name');
            $table->string('job_title')->nullable();
            $table->text('description')->nullable();

            // Profile image
            $table->string('image')->nullable();

            // Social media links
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('x')->nullable(); // formerly Twitter
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('tiktok')->nullable();

            // Sorting + visibility
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['sort']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('center_members');
    }
};
