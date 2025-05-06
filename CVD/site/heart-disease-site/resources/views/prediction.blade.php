@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Heart Disease Prediction</h2>
        <form method="POST" action="{{ route('predict') }}">
            @csrf

            <!-- Section 1: General Health Metrics -->
            <div class="form-section card p-4 fade-in">
                <h5>General Health Metrics</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Age (20-100)</label>
                        <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" min="20" max="100" value="{{ old('age') }}" required>
                        @error('age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sex" class="form-label">Sex</label>
                        <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                            <option value="">Select Sex</option>
                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="resting_blood_pressure" class="form-label">Resting Blood Pressure (50-200 mmHg)</label>
                        <input type="number" class="form-control @error('resting_blood_pressure') is-invalid @enderror" id="resting_blood_pressure" name="resting_blood_pressure" min="50" max="200" value="{{ old('resting_blood_pressure') }}" required>
                        @error('resting_blood_pressure')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cholesterol" class="form-label">Cholesterol (100-500 mg/dL)</label>
                        <input type="number" class="form-control @error('cholesterol') is-invalid @enderror" id="cholesterol" name="cholesterol" min="100" max="500" value="{{ old('cholesterol') }}" required>
                        @error('cholesterol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Cardiac Stress Indicators -->
            <div class="form-section card p-4 fade-in">
                <h5>Cardiac Stress Indicators</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="chest_pain_type" class="form-label">Chest Pain Type</label>
                        <select class="form-control @error('chest_pain_type') is-invalid @enderror" id="chest_pain_type" name="chest_pain_type" required>
                            <option value="">Select Type</option>
                            <option value="Typical Angina" {{ old('chest_pain_type') == 'Typical Angina' ? 'selected' : '' }}>Typical Angina</option>
                            <option value="Atypical Angina" {{ old('chest_pain_type') == 'Atypical Angina' ? 'selected' : '' }}>Atypical Angina</option>
                            <option value="Non-Anginal Pain" {{ old('chest_pain_type') == 'Non-Anginal Pain' ? 'selected' : '' }}>Non-Anginal Pain</option>
                            <option value="Asymptomatic" {{ old('chest_pain_type') == 'Asymptomatic' ? 'selected' : '' }}>Asymptomatic</option>
                        </select>
                        @error('chest_pain_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fasting_blood_sugar" class="form-label">Fasting Blood Sugar</label>
                        <select class="form-control @error('fasting_blood_sugar') is-invalid @enderror" id="fasting_blood_sugar" name="fasting_blood_sugar" required>
                            <option value="">Select Value</option>
                            <option value="<120 mg/dL" {{ old('fasting_blood_sugar') == '<120 mg/dL' ? 'selected' : '' }}><120 mg/dL</option>
                            <option value=">120 mg/dL" {{ old('fasting_blood_sugar') == '>120 mg/dL' ? 'selected' : '' }}>>120 mg/dL</option>
                        </select>
                        @error('fasting_blood_sugar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="max_heart_rate_achieved" class="form-label">Max Heart Rate Achieved (60-220 bpm)</label>
                        <input type="number" class="form-control @error('max_heart_rate_achieved') is-invalid @enderror" id="max_heart_rate_achieved" name="max_heart_rate_achieved" min="60" max="220" value="{{ old('max_heart_rate_achieved') }}" required>
                        @error('max_heart_rate_achieved')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Advanced Diagnostics -->
            <div class="form-section card p-4 fade-in">
                <h5>Advanced Diagnostics</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="resting_electrocardiogram" class="form-label">Resting Electrocardiogram</label>
                        <select class="form-control @error('resting_electrocardiogram') is-invalid @enderror" id="resting_electrocardiogram" name="resting_electrocardiogram" required>
                            <option value="">Select Result</option>
                            <option value="Normal" {{ old('resting_electrocardiogram') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="ST-T Wave Abnormality" {{ old('resting_electrocardiogram') == 'ST-T Wave Abnormality' ? 'selected' : '' }}>ST-T Wave Abnormality</option>
                            <option value="Left Ventricular Hypertrophy" {{ old('resting_electrocardiogram') == 'Left Ventricular Hypertrophy' ? 'selected' : '' }}>Left Ventricular Hypertrophy</option>
                        </select>
                        @error('resting_electrocardiogram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="exercise_induced_angina" class="form-label">Exercise Induced Angina</label>
                        <select class="form-control @error('exercise_induced_angina') is-invalid @enderror" id="exercise_induced_angina" name="exercise_induced_angina" required>
                            <option value="">Select Value</option>
                            <option value="No" {{ old('exercise_induced_angina') == 'No' ? 'selected' : '' }}>No</option>
                            <option value="Yes" {{ old('exercise_induced_angina') == 'Yes' ? 'selected' : '' }}>Yes</option>
                        </select>
                        @error('exercise_induced_angina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="st_depression" class="form-label">ST Depression (0-6.2)</label>
                        <input type="number" step="0.1" class="form-control @error('st_depression') is-invalid @enderror" id="st_depression" name="st_depression" min="0" max="6.2" value="{{ old('st_depression') }}" required>
                        @error('st_depression')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="st_slope" class="form-label">ST Slope</label>
                        <select class="form-control @error('st_slope') is-invalid @enderror" id="st_slope" name="st_slope" required>
                            <option value="">Select Slope</option>
                            <option value="Upsloping" {{ old('st_slope') == 'Upsloping' ? 'selected' : '' }}>Upsloping</option>
                            <option value="Flat" {{ old('st_slope') == 'Flat' ? 'selected' : '' }}>Flat</option>
                            <option value="Downsloping" {{ old('st_slope') == 'Downsloping' ? 'selected' : '' }}>Downsloping</option>
                        </select>
                        @error('st_slope')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="num_major_vessels" class="form-label">Number of Major Vessels</label>
                        <select class="form-control @error('num_major_vessels') is-invalid @enderror" id="num_major_vessels" name="num_major_vessels" required>
                            <option value="">Select Number</option>
                            <option value="0" {{ old('num_major_vessels') == '0' ? 'selected' : '' }}>0</option>
                            <option value="1" {{ old('num_major_vessels') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('num_major_vessels') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('num_major_vessels') == '3' ? 'selected' : '' }}>3</option>
                        </select>
                        @error('num_major_vessels')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="thalassemia" class="form-label">Thalassemia</label>
                        <select class="form-control @error('thalassemia') is-invalid @enderror" id="thalassemia" name="thalassemia" required>
                            <option value="">Select Type</option>
                            <option value="Normal" {{ old('thalassemia') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Fixed Defect" {{ old('thalassemia') == 'Fixed Defect' ? 'selected' : '' }}>Fixed Defect</option>
                            <option value="Reversible Defect" {{ old('thalassemia') == 'Reversible Defect' ? 'selected' : '' }}>Reversible Defect</option>
                        </select>
                        @error('thalassemia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Model Selection -->
            <div class="form-section card p-4 fade-in">
                <h5>Select AI Model</h5>
                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <select class="form-control @error('model') is-invalid @enderror" id="model" name="model" required>
                        <option value="">Select Model</option>
                        <option value="CNN" {{ old('model') == 'CNN' ? 'selected' : '' }}>CNN</option>
                        <option value="Transformer" {{ old('model') == 'Transformer' ? 'selected' : '' }}>Transformer</option>
                        <option value="LGBMClassifier" {{ old('model') == 'LGBMClassifier' ? 'selected' : '' }}>LGBMClassifier</option>
                        <option value="Tuned Transformer" {{ old('model') == 'Tuned Transformer' ? 'selected' : '' }}>Tuned Transformer</option>
                    </select>
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Predict</button>
        </form>
        <div id="result" class="mt-4"></div>
    </div>

    <script>
        document.getElementById('predictionForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            try {
                const response = await axios.post('{{ route('predict') }}', data, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = response.data;
                document.getElementById('result').innerHTML = `
                    <div class="alert alert-info">
                        <h5>Prediction Result (Model: ${result.model})</h5>
                        <p><strong>Probability of Heart Disease:</strong> ${(result.probability * 100).toFixed(2)}%</p>
                        <p><strong>Prediction:</strong> ${result.prediction}</p>
                    </div>
                `;
            } catch (error) {
                const errorMessage = error.response?.data?.error || 'Prediction failed. Please try again.';
                document.getElementById('result').innerHTML = `
                    <div class="alert alert-danger">
                        <strong>Error:</strong> ${errorMessage}
                    </div>
                `;
            }
        });
    </script>
@endsection