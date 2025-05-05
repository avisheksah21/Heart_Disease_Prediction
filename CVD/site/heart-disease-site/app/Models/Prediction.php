<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ADDED: Import HasFactory trait

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'age', 'sex', 'chest_pain_type', 'resting_blood_pressure', 'cholesterol',
        'fasting_blood_sugar', 'resting_electrocardiogram', 'max_heart_rate_achieved',
        'exercise_induced_angina', 'st_depression', 'st_slope', 'num_major_vessels',
        'thalassemia', 'prediction', 'prediction_score', 'model_used', 'model_accuracy'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
