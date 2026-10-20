<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_sw');
            $table->string('slug')->unique();
            $table->string('category', 60)->default('General Wellness'); // Maternal Health, Chronic Diseases, Nutrition, Child Health
            $table->string('author_name')->default('Clinical Medical Staff');
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_sw')->nullable();
            $table->longText('content_en');
            $table->longText('content_sw');
            $table->string('featured_image')->nullable();
            $table->text('disclaimer_en')->nullable();
            $table->text('disclaimer_sw')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_articles');
    }
};
