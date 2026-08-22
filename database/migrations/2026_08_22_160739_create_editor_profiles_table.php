<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('editor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('editor_type', ['Editor-in-Chief', 'Associate Editor', 'Guest Editor', 'Managing Editor']);
            $table->foreignId('assigned_journal_id')->nullable()->constrained('journals')->nullOnDelete();
            $table->string('section_id')->nullable();
            $table->enum('decision_permission_level', ['Accept/Reject Rights', 'Desk Reject Only', 'Advisory'])->default('Advisory');
            $table->unsignedInteger('active_manuscript_count')->default(0);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('editor_profiles');
    }
};