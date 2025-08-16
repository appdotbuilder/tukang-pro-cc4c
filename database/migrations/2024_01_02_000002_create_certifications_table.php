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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Certification name');
            $table->text('description')->nullable();
            $table->enum('level', ['basic', 'intermediate', 'advanced', 'expert']);
            $table->decimal('rate_multiplier', 3, 2)->default(1.00)->comment('Rate multiplier for this certification level');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('level');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};