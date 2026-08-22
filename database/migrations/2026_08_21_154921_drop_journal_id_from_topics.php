<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if ($this->isSQLite()) {
            return;
        }

        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['journal_id']);
            $table->dropUnique(['journal_id', 'slug']);
            $table->dropColumn('journal_id');
        });
    }

    public function down(): void
    {
        if ($this->isSQLite()) {
            return;
        }

        Schema::table('topics', function (Blueprint $table) {
            $table->foreignId('journal_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    private function isSQLite(): bool
    {
        return config('database.connections.' . config('database.default') . '.driver') === 'sqlite';
    }
};