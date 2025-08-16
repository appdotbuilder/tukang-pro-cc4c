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
        Schema::create('craftsman_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('craftsman_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->foreignId('certification_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            
            $table->unique(['craftsman_profile_id', 'skill_id']);
            $table->index(['skill_id', 'certification_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('craftsman_skills');
    }
};