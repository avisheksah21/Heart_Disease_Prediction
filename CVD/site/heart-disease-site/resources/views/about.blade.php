@extends('layouts.app')

@section('content')
<div class="about-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="about-card shadow-sm">
                    <h1 class="text-center mb-4">About HeartSafe Predictor</h1>
                    
                    <div class="about-section mb-5">
                        <h2><i class="fas fa-heartbeat me-2"></i>Project Overview</h2>
                        <p>HeartSafe Predictor is a machine learning-based web application developed in 2025 by Avishek Sah for educational and demonstration purposes. This tool predicts the likelihood of heart disease based on various medical parameters provided by users.</p>
                        <p>While this application demonstrates the power of AI in healthcare diagnostics, it's important to note that the predictions are not 100% accurate and should not replace professional medical advice.</p>
                    </div>

                    <div class="about-section mb-5">
                        <h2><i class="fas fa-brain me-2"></i>Technology Stack</h2>
                        <p>The prediction system utilizes an ensemble of advanced machine learning models:</p>
                        <ul class="tech-list">
                            <li><strong>LGBMClassifier</strong> - Light Gradient Boosting Machine</li>
                            <li><strong>CNN</strong> - Convolutional Neural Network</li>
                            <li><strong>Transformer</strong> - Attention-based architecture</li>
                            <li><strong>Tuned Transformer</strong> - Optimized for medical data</li>
                        </ul>
                        <p>These models work together to analyze the input parameters and provide a risk assessment.</p>
                    </div>

                    <div class="about-section mb-5">
                        <h2><i class="fas fa-clipboard-list me-2"></i>Medical Parameters Analyzed</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Description</th>
                                        <th>Values</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Age</td>
                                        <td>Age in years</td>
                                        <td>Numerical</td>
                                    </tr>
                                    <tr>
                                        <td>Sex</td>
                                        <td>Biological sex</td>
                                        <td>1 = male, 0 = female</td>
                                    </tr>
                                    <tr>
                                        <td>Chest Pain (cp)</td>
                                        <td>Chest pain type</td>
                                        <td>0: typical angina<br>1: atypical angina<br>2: non-anginal pain<br>3: asymptomatic</td>
                                    </tr>
                                    <tr>
                                        <td>Resting BP</td>
                                        <td>Resting blood pressure (mm Hg)</td>
                                        <td>Numerical</td>
                                    </tr>
                                    <tr>
                                        <td>Cholesterol</td>
                                        <td>Serum cholesterol (mg/dl)</td>
                                        <td>Numerical</td>
                                    </tr>
                                    <tr>
                                        <td>Fasting Blood Sugar</td>
                                        <td>Fasting blood sugar > 120 mg/dl</td>
                                        <td>1 = true, 0 = false</td>
                                    </tr>
                                    <tr>
                                        <td>Resting ECG</td>
                                        <td>Resting electrocardiographic results</td>
                                        <td>0: normal<br>1: ST-T wave abnormality<br>2: left ventricular hypertrophy</td>
                                    </tr>
                                    <tr>
                                        <td>Max Heart Rate</td>
                                        <td>Maximum heart rate achieved</td>
                                        <td>Numerical</td>
                                    </tr>
                                    <tr>
                                        <td>Exercise Angina</td>
                                        <td>Exercise induced angina</td>
                                        <td>1 = yes, 0 = no</td>
                                    </tr>
                                    <tr>
                                        <td>ST Depression</td>
                                        <td>ST depression induced by exercise</td>
                                        <td>Numerical</td>
                                    </tr>
                                    <tr>
                                        <td>Slope</td>
                                        <td>Slope of peak exercise ST segment</td>
                                        <td>0: upsloping<br>1: flat<br>2: downsloping</td>
                                    </tr>
                                    <tr>
                                        <td>Major Vessels</td>
                                        <td>Number of major vessels colored by fluoroscopy</td>
                                        <td>0-3</td>
                                    </tr>
                                    <tr>
                                        <td>Thal</td>
                                        <td>Thalassemia</td>
                                        <td>1: fixed defect<br>2: normal<br>3: reversible defect</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="about-section">
                        <h2><i class="fas fa-user-md me-2"></i>Intended Audience</h2>
                        <p>This tool is designed for:</p>
                        <ul>
                            <li>Medical students learning about cardiovascular risk factors</li>
                            <li>Healthcare professionals familiar with cardiac terminology</li>
                            <li>Researchers exploring AI applications in medicine</li>
                            <li>Tech enthusiasts interested in machine learning implementations</li>
                        </ul>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Important Note:</strong> This application is for educational purposes only. Always consult with qualified healthcare professionals for medical diagnoses and treatment.
                        </div>
                    </div>
                </div>

                <div class="developer-note mt-4 text-center">
                    <p class="text-muted">Developed by Avishek Sah © 2025 | Academic Project</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection