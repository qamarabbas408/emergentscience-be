<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing data from FK to pivot table
        DB::table('journals')
            ->whereNotNull('discipline_category_id')
            ->orderBy('id')
            ->each(function ($journal) {
                DB::table('discipline_category_journal')->insert([
                    'discipline_category_id' => $journal->discipline_category_id,
                    'journal_id' => $journal->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

        Schema::table('journals', function (Blueprint $table) {
            $table->dropForeign(['discipline_category_id']);
            $table->dropColumn('discipline_category_id');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->foreignId('discipline_category_id')->nullable()->after('doi_prefix')->constrained()->nullOnDelete();
        });

        // Migrate data back from pivot to FK (takes first category per journal)
        $pivots = DB::table('discipline_category_journal')
            ->select('journal_id', DB::raw('MIN(discipline_category_id) as category_id'))
            ->groupBy('journal_id')
            ->get();

        foreach ($pivots as $pivot) {
            DB::table('journals')
                ->where('id', $pivot->journal_id)
                ->update(['discipline_category_id' => $pivot->category_id]);
        }

        DB::table('discipline_category_journal')->truncate();
    }
};
