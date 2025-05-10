<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Tests\TestCase;

class PredictionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_prediction_form_for_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('prediction'));

        $response->assertStatus(200);
        $response->assertViewIs('prediction');
    }

    /** @test */
    public function it_redirects_unauthenticated_user_to_login()
    {
        $response = $this->get(route('prediction'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_successfully_submits_prediction_and_stores_data()
    {
        // Mock the Flask API response
        Http::fake([
            'http://localhost:5000/predict' => Http::response([
                'prediction' => 'Heart Disease',
                'probability' => 0.85,
                'model' => 'CNN'
            ], 200)
        ]);

        $user = User::factory()->create();
        $formData = [
            'age' => 45,
            'sex' => 'Male',
            'chest_pain_type' => 'Typical Angina',
            'resting_blood_pressure' => 120,
            'cholesterol' => 200,
            'fasting_blood_sugar' => '<120 mg/dL',
            'resting_electrocardiogram' => 'Normal',
            'max_heart_rate_achieved' => 150,
            'exercise_induced_angina' => 'No',
            'st_depression' => 1.0,
            'st_slope' => 'Upsloping',
            'num_major_vessels' => 0,
            'thalassemia' => 'Normal',
            'model' => 'CNN',
        ];

        $response = $this->actingAs($user)->post(route('predict'), $formData);

        $response->assertViewHas('data', function ($data) {
            return $data['prediction'] === 'Heart Disease';
        });

        $this->assertDatabaseHas('predictions', [
            'user_id' => $user->id,
            'prediction' => 'Disease',
            'model_used' => 'CNN',
            'prediction_score' => 85.0
        ]);
    }

    /** @test */
    public function it_fails_validation_with_invalid_data()
    {
        $user = User::factory()->create();
        $formData = [
            'age' => 15, // Invalid: below minimum
            'sex' => 'Invalid', // Invalid: not Male/Female
            'model' => 'Invalid Model' // Invalid: not in allowed models
        ];

        $response = $this->actingAs($user)->post(route('predict'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['age', 'sex', 'model']);
    }
}