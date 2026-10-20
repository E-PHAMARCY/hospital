<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('tender_number', 50)->unique();
            $table->string('title_en');
            $table->string('title_sw');
            $table->string('slug')->unique();
            $table->longText('description_en');
            $table->longText('description_sw');
            $table->string('document_path')->nullable();
            $table->dateTime('publication_date');
            $table->dateTime('submission_deadline');
            $table->string('status', 30)->default('open'); // open, closed, awarded, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
