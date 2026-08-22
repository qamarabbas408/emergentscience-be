<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviewer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('expertise_keywords')->nullable();
            $table->enum('review_availability_status', ['Available', 'On Leave', 'Max Capacity'])->default('Available');
            $table->unsignedInteger('max_concurrent_reviews')->default(5);
            $table->unsignedInteger('total_reviews_completed')->default(0);
            $table->float('average_review_time_days')->nullable();
            $table->float('rating_score')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviewer_profiles');
    }
};