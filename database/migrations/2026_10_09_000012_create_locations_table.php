<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_sw');
            $table->string('slug')->unique();
            $table->string('address_en');
            $table->string('address_sw');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('opening_hours_en')->nullable();
            $table->string('opening_hours_sw')->nullable();
            $table->text('google_map_url')->nullable();
            $table->string('image')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_sw')->nullable();
            $table->boolean('is_main')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
