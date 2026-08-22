<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->enum('title', ['Dr.', 'Prof.', 'Mr.', 'Ms.', 'Mrs.', 'Mx.'])->nullable()->after('last_name');
            $table->string('primary_affiliation')->nullable()->after('title');
            $table->string('country')->nullable()->after('primary_affiliation');
            $table->string('city')->nullable()->after('country');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('orcid_id')->unique()->nullable()->after('postal_code');
            $table->text('biography')->nullable()->after('orcid_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'middle_name', 'last_name', 'title',
                'primary_affiliation', 'country', 'city', 'postal_code',
                'orcid_id', 'biography',
            ]);
        });
    }
};