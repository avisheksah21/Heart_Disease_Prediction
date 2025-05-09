<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Prediction
 *
 * Represents a heart disease prediction made by a user.
 * Stores the input features, the prediction result, score, and the model used.
 */
class Prediction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'age',
        'sex',
        'chest_pain_type',
        'resting_blood_pressure',
        'cholesterol',
        'fasting_blood_sugar',
        'resting_electrocardiogram',
        'max_heart_rate_achieved',
        'exercise_induced_angina',
        'st_depression',
        'st_slope',
        'num_major_vessels',
        'thalassemia',
        'prediction',
        'prediction_score',
        'model_used',
        'model_accuracy'
    ];

    /**
     * Get the user that owns the prediction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
