<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('round')->default(1);
            $table->enum('status', [
                'submitted',
                'under_review',
                'revision_requested',
                'accepted',
                'rejected',
            ])->default('submitted');
            $table->text('cover_letter')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['article_id', 'round']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
