<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('abstract');
            $table->json('keywords');
            $table->string('doi')->nullable();
            $table->string('slug')->unique();
            $table->enum('article_type', [
                'research-article',
                'review',
                'systematic-review',
                'meta-analysis',
                'brief-report',
                'case-report',
                'editorial',
                'letter',
                'correction',
                'protocol',
            ])->default('research-article');
            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'revision_required',
                'accepted',
                'published',
                'rejected',
                'withdrawn',
            ])->default('draft');
            $table->string('language', 5)->default('en');
            $table->unsignedInteger('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('page_start')->nullable();
            $table->string('page_end')->nullable();
            $table->date('publication_date')->nullable();
            $table->date('date_submitted')->nullable();
            $table->date('date_accepted')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('download_count')->default(0);
            $table->unsignedInteger('citation_count')->default(0);
            $table->timestamps();

            $table->index('journal_id');
            $table->index('status');
            $table->index('article_type');
            $table->index('publication_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
