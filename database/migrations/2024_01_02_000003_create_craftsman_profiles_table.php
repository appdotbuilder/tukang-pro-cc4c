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
        Schema::create('craftsman_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->integer('years_experience')->default(0);
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->string('location')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->json('work_areas')->nullable()->comment('Array of areas they serve');
            $table->string('profile_photo')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->decimal('insurance_rate', 5, 2)->default(0.00)->comment('Insurance rate percentage');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('location');
            $table->index('rating');
            $table->index('is_available');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('craftsman_profiles');
    }
};