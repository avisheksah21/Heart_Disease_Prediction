<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ADDED: Import Auth facade
use App\Models\Prediction; // ADDED: Import Prediction model

class PredictionController extends Controller
{
    public function index()
    {
        return view('prediction');
    }

    public function predict(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:20|max:100',
            'sex' => 'required|in:Male,Female',
            'resting_blood_pressure' => 'required|integer|min:50|max:200',
            'cholesterol' => 'required|integer|min:100|max:500',
            'chest_pain_type' => 'required|in:Typical Angina,Atypical Angina,Non-Anginal Pain,Asymptomatic',
            'fasting_blood_sugar' => 'required|in:<120 mg/dL,>120 mg/dL',
            'max_heart_rate_achieved' => 'required|integer|min:60|max:220',
            'resting_electrocardiogram' => 'required|in:Normal,ST-T Wave Abnormality,Left Ventricular Hypertrophy',
            'exercise_induced_angina' => 'required|in:No,Yes',
            'st_depression' => 'required|numeric|min:0|max:6.2',
            'st_slope' => 'required|in:Upsloping,Flat,Downsloping',
            'num_major_vessels' => 'required|integer|min:0|max:3',
            'thalassemia' => 'required|in:Normal,Fixed Defect,Reversible Defect',
            'model' => 'required|in:CNN,Transformer,LGBMClassifier,Tuned Transformer',
        ]);

        // Mock prediction (replace with actual model integration)
        $prediction = rand(0, 1) ? 'Disease' : 'No Disease';
        $score = rand(60, 100) + (rand(0, 99) / 100); // Random score between 60-100

        $modelAccuracies = [
            'CNN' => 96.08,
            'Transformer' => 96.08,
            'LGBMClassifier' => 95.00,
            'Tuned Transformer' => 98.04
        ];

        $predictionData = array_merge($validated, [
            'user_id' => Auth::id(),
            'prediction' => $prediction,
            'prediction_score' => $score,
            'model_used' => $validated['model'],
            'model_accuracy' => $modelAccuracies[$validated['model']],
        ]);

        Prediction::create($predictionData);

        return view('result', [
            'prediction' => $prediction,
            'score' => $score,
            'model' => $validated['model'],
            'accuracy' => $modelAccuracies[$validated['model']],
        ]);
    }
}
