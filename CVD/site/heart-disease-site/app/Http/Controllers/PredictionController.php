<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Prediction;

/**
 * Controller for handling heart disease predictions.
 */
class PredictionController extends Controller
{
    /**
     * Display the prediction form view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('prediction');
    }

    /**
     * Handle the prediction request, send data to the prediction API,
     * save the result, and display the result view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function predict(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:20|max:100',
            'sex' => 'required|in:Male,Female',
            'chest_pain_type' => 'required|in:Typical Angina,Atypical Angina,Non-Anginal Pain,Asymptomatic',
            'resting_blood_pressure' => 'required|integer|min:50|max:200',
            'cholesterol' => 'required|integer|min:100|max:500',
            'fasting_blood_sugar' => 'required|in:<120 mg/dL,>120 mg/dL',
            'resting_electrocardiogram' => 'required|in:Normal,ST-T Wave Abnormality,Left Ventricular Hypertrophy',
            'max_heart_rate_achieved' => 'required|integer|min:60|max:220',
            'exercise_induced_angina' => 'required|in:No,Yes',
            'st_depression' => 'required|numeric|min:0|max:6.2',
            'st_slope' => 'required|in:Upsloping,Flat,Downsloping',
            'num_major_vessels' => 'required|integer|min:0|max:3',
            'thalassemia' => 'required|in:Normal,Fixed Defect,Reversible Defect',
            'model' => 'required|in:CNN,Transformer,LGBMClassifier,Tuned Transformer',
        ]);

        // Map fields to numeric representations
        $numericData = [
            'age' => (int) $validated['age'],
            'sex' => $validated['sex'] === 'Male' ? 1 : 0,
            'chest_pain_type' => match ($validated['chest_pain_type']) {
                'Typical Angina' => 0,
                'Atypical Angina' => 1,
                'Non-Anginal Pain' => 2,
                'Asymptomatic' => 3,
            },
            'resting_blood_pressure' => (int) $validated['resting_blood_pressure'],
            'cholesterol' => (int) $validated['cholesterol'],
            'fasting_blood_sugar' => $validated['fasting_blood_sugar'] === '>120 mg/dL' ? 1 : 0,
            'resting_electrocardiogram' => match ($validated['resting_electrocardiogram']) {
                'Normal' => 0,
                'ST-T Wave Abnormality' => 1,
                'Left Ventricular Hypertrophy' => 2,
            },
            'max_heart_rate_achieved' => (int) $validated['max_heart_rate_achieved'],
            'exercise_induced_angina' => $validated['exercise_induced_angina'] === 'Yes' ? 1 : 0,
            'st_depression' => (float) $validated['st_depression'],
            'st_slope' => match ($validated['st_slope']) {
                'Upsloping' => 0,
                'Flat' => 1,
                'Downsloping' => 2,
            },
            'num_major_vessels' => (int) $validated['num_major_vessels'],
            'thalassemia' => match ($validated['thalassemia']) {
                'Normal' => 1,
                'Fixed Defect' => 2,
                'Reversible Defect' => 3,
            },
        ];

        try {
            // Prepare data for API
            $apiData = [
                'input' => array_values($numericData),
                'model' => $validated['model']
            ];

            // Send POST request 
            $response = Http::post('http://localhost:5000/predict', $apiData);

            if ($response->successful()) {
                $result = $response->json();
                $modelAccuracies = [
                    'CNN' => 96.08,
                    'Transformer' => 96.08,
                    'LGBMClassifier' => 95.00,
                    'Tuned Transformer' => 98.04
                ];
                $predictionData = array_merge($validated, [
                    'user_id' => Auth::id(),
                    'prediction' => $result['prediction'] === 'Heart Disease' ? 'Disease' : 'No Disease',
                    'prediction_score' => $result['probability'] * 100, // Convert to percentage
                    'model_used' => $validated['model'],
                    'model_accuracy' => $modelAccuracies[$validated['model']],
                ]);

                Prediction::create($predictionData);
                $data = [];
                $data = [
                    'probability' => $result['probability'],
                    'prediction' => $result['prediction'],
                    'model' => $result['model'],
                    'accuracy' => $modelAccuracies[$validated['model']]
                ];

                return view('result', compact('data'));
            } else {
                Log::error('Prediction API error: ' . $response->body());
                return response()->json(['error' => 'Prediction failed'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Prediction request failed: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}