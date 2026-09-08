<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviewer_profiles', function (Blueprint $table) {
            $table->enum('reviewer_status', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('reviewer_profiles', function (Blueprint $table) {
            $table->dropColumn('reviewer_status');
        });
    }
};
