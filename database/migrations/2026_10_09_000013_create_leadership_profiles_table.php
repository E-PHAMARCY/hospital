<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leadership_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title_en');
            $table->string('title_sw');
            $table->string('role_category', 60)->default('Executive Management'); // Board of Directors, Executive Management, Clinical Directorate
            $table->longText('bio_en')->nullable();
            $table->longText('bio_sw')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leadership_profiles');
    }
};
