<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_sw');
            $table->text('message_en');
            $table->text('message_sw');
            $table->string('type', 30)->default('info'); // info, urgent, alert, notice
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->string('action_url')->nullable();
            $table->string('action_text_en')->nullable();
            $table->string('action_text_sw')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
