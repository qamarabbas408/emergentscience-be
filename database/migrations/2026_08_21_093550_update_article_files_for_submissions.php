<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_files', function (Blueprint $table) {
            $table->foreignId('submission_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->string('original_name')->after('file_type');
        });

        // Migrate existing data: create a submission per article and link files
        $files = DB::table('article_files')->whereNotNull('article_id')->get();
        $grouped = $files->groupBy('article_id');

        foreach ($grouped as $articleId => $articleFiles) {
            $submissionId = DB::table('submissions')->insertGetId([
                'article_id' => $articleId,
                'round' => 1,
                'status' => 'submitted',
                'submitted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($articleFiles as $file) {
                DB::table('article_files')
                    ->where('id', $file->id)
                    ->update([
                        'submission_id' => $submissionId,
                        'original_name' => $file->file_name,
                    ]);
            }
        }

        Schema::table('article_files', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropIndex(['article_id', 'file_type']);
            $table->dropColumn('article_id');
            $table->renameColumn('file_path', 'storage_path');
        });
    }

    public function down(): void
    {
        Schema::table('article_files', function (Blueprint $table) {
            $table->renameColumn('storage_path', 'file_path');
            $table->foreignId('article_id')->nullable()->after('submission_id')->constrained();
            $table->index(['article_id', 'file_type']);
            $table->dropForeign(['submission_id']);
            $table->dropColumn(['submission_id', 'original_name']);
        });
    }
};
