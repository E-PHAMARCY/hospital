<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_sw');
            $table->text('description_en')->nullable();
            $table->text('description_sw')->nullable();
            $table->string('category', 60)->default('Patient Guide'); // Patient Guide, Clinical Protocol, Reports, Forms
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('file_type', 20)->default('PDF');
            $table->string('file_size', 30)->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
