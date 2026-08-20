<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_types', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->unsignedInteger('max_word_count')->nullable()->after('description');
            $table->unsignedInteger('max_summary_words')->nullable()->after('max_word_count');
            $table->unsignedInteger('max_figures_tables')->nullable()->after('max_summary_words');
        });
    }

    public function down(): void
    {
        Schema::table('article_types', function (Blueprint $table) {
            $table->dropColumn(['description', 'max_word_count', 'max_summary_words', 'max_figures_tables']);
        });
    }
};
