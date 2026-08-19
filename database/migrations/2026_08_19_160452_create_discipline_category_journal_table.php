<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('discipline_category_journal');
        Schema::create('discipline_category_journal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discipline_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('journal_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['discipline_category_id', 'journal_id'], 'dc_journal_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discipline_category_journal');
    }
};
