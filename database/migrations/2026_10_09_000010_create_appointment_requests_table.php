<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 40)->unique();
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_phone');
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->date('preferred_date');
            $table->string('preferred_time', 50); // Morning (08:00 - 12:00), Afternoon (13:00 - 17:00), Evening (17:00 - 20:00)
            $table->text('reason');
            $table->string('status', 30)->default('pending')->index(); // pending, confirmed, completed, cancelled
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_requests');
    }
};
