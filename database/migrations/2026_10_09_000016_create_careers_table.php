<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_sw');
            $table->string('slug')->unique();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('employment_type', 40)->default('Full-Time'); // Full-Time, Part-Time, Contract, Locum
            $table->string('location')->default('Main Campus');
            $table->longText('description_en');
            $table->longText('description_sw');
            $table->longText('requirements_en')->nullable();
            $table->longText('requirements_sw')->nullable();
            $table->date('deadline');
            $table->string('application_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
