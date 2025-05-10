<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prediction>
 */
class PredictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'user_id' => \App\Models\User::factory(),
        'age' => $this->faker->numberBetween(20, 100),
        'sex' => $this->faker->randomElement(['Male', 'Female']),
        'chest_pain_type' => $this->faker->randomElement(['Typical Angina', 'Atypical Angina', 'Non-Anginal Pain', 'Asymptomatic']),
        'resting_blood_pressure' => $this->faker->numberBetween(50, 200),
        'cholesterol' => $this->faker->numberBetween(100, 500),
        'fasting_blood_sugar' => $this->faker->randomElement(['<120 mg/dL', '>120 mg/dL']),
        'resting_electrocardiogram' => $this->faker->randomElement(['Normal', 'ST-T Wave Abnormality', 'Left Ventricular Hypertrophy']),
        'max_heart_rate_achieved' => $this->faker->numberBetween(60, 220),
        'exercise_induced_angina' => $this->faker->randomElement(['No', 'Yes']),
        'st_depression' => $this->faker->randomFloat(1, 0, 6.2),
        'st_slope' => $this->faker->randomElement(['Upsloping', 'Flat', 'Downsloping']),
        'num_major_vessels' => $this->faker->numberBetween(0, 3),
        'thalassemia' => $this->faker->randomElement(['Normal', 'Fixed Defect', 'Reversible Defect']),
        'model_used' => $this->faker->randomElement(['CNN', 'Transformer', 'LGBMClassifier', 'Tuned Transformer']),
        'prediction' => $this->faker->randomElement(['Disease', 'No Disease']),
        'prediction_score' => $this->faker->randomFloat(2, 0, 100),
        'model_accuracy' => $this->faker->randomFloat(2, 90, 100),
    ];
    }
}
