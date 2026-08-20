<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_article_type_index');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('article_type_id')->nullable()->after('slug')->constrained('article_types')->nullOnDelete();
        });

        DB::table('articles')->update(['article_type_id' => 1]);

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('article_type');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('article_type')->default('research-article')->after('slug');
        });

        DB::table('articles')->update(['article_type' => 'research-article']);

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['article_type_id']);
            $table->dropColumn('article_type_id');
        });
    }
};
