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
        Schema::create('gamification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('action_name')->unique(); // e.g., 'complete_lesson', 'pass_quiz'
            $table->string('display_name'); // e.g., 'Complete a Lesson'
            $table->unsignedInteger('points')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamification_settings');
    }
};
