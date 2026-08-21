<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_topics', function (Blueprint $table) {
            $table->foreignId('journal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->primary(['journal_id', 'topic_id']);
        });

        // Migrate existing data: each topic's journal_id → pivot row
        $topics = DB::table('topics')->whereNotNull('journal_id')->get();
        $rows = $topics->map(fn ($t) => ['journal_id' => $t->journal_id, 'topic_id' => $t->id])->toArray();
        DB::table('journal_topics')->insert($rows);
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_topics');
    }
};
