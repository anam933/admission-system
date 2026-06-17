<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {

            $table->id();

            // Candidate
            $table->foreignId('candidate_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Institute
            $table->foreignId('institute_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Course
            $table->foreignId('course_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Basic Details
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            // Fees
            $table->decimal('total_fees', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);

            // Created By
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Status
            $table->enum('status', [
                'new',
                'converted',
                'rejected',
                'completed',
                'pending'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};