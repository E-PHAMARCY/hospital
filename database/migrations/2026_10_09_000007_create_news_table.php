<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_sw');
            $table->string('slug')->unique();
            $table->string('category', 50)->default('Health Tips'); // Press Release, Health Tips, Clinical Updates, General
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_sw')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_sw')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
