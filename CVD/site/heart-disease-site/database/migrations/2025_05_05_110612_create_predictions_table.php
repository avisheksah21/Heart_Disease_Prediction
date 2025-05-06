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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age');
            $table->string('sex');
            $table->string('chest_pain_type');
            $table->integer('resting_blood_pressure');
            $table->integer('cholesterol');
            $table->string('fasting_blood_sugar');
            $table->string('resting_electrocardiogram');
            $table->integer('max_heart_rate_achieved');
            $table->string('exercise_induced_angina');
            $table->float('st_depression');
            $table->string('st_slope');
            $table->integer('num_major_vessels');
            $table->integer('thalassemia');
            $table->string('model_used');
            $table->string('prediction');
            $table->float('prediction_score');
            $table->float('model_accuracy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};