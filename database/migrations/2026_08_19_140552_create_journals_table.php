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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('abbreviation')->nullable();
            $table->string('issn')->nullable();
            $table->string('eissn')->nullable();
            $table->string('doi_prefix');
            $table->string('discipline')->nullable();
            $table->string('license')->nullable();
            $table->text('scope')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('apc_amount', 10, 2)->nullable();
            $table->string('apc_currency', 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
