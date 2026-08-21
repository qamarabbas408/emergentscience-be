<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('database.default') === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE article_files MODIFY file_type ENUM('manuscript', 'figures', 'supplementary', 'reviewer_materials') NOT NULL");
    }

    public function down(): void
    {
        if (config('database.default') === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE article_files MODIFY file_type ENUM('manuscript', 'figures', 'supplementary') NOT NULL");
    }
};
