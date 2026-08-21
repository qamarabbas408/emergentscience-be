<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_types', function (Blueprint $table) {
            $table->json('file_requirements')->nullable()->after('max_figures_tables');
        });
    }

    public function down(): void
    {
        Schema::table('article_types', function (Blueprint $table) {
            $table->dropColumn('file_requirements');
        });
    }
};
