@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Dashboard</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card p-4 fade-in">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>User Name</th>
                            <th>Date</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Chest Pain</th>
                            <th>BP</th>
                            <th>Cholesterol</th>
                            <th>Blood Sugar</th>
                            <th>ECG</th>
                            <th>Max HR</th>
                            <th>Exercise Angina</th>
                            <th>ST Depression</th>
                            <th>ST Slope</th>
                            <th>Vessels</th>
                            <th>Thalassemia</th>
                            <th>Prediction</th>
                            <th>Disease Probability</th>
                            <th>Model</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($predictions_data as $prediction)
                            <tr>
                                <td>{{ $prediction->user->name ?? 'N/A' }}</td>
                                <td>{{ $prediction->created_at->format('Y-m-d') }}</td>
                                <td>{{ $prediction->age }}</td>
                                <td>{{ $prediction->sex == 1 ? 'Male' : 'Female' }}</td>
                                <td>
                                    @php
                                        $chestPainTypes = [
                                            1 => 'Typical Angina',
                                            2 => 'Atypical Angina',
                                            3 => 'Non-anginal Pain',
                                            4 => 'Asymptomatic'
                                        ];
                                        echo $chestPainTypes[$prediction->chest_pain_type] ?? $prediction->chest_pain_type;
                                    @endphp
                                </td>
                                <td>{{ $prediction->resting_blood_pressure }}</td>
                                <td>{{ $prediction->cholesterol }}</td>
                                <td>{{ $prediction->fasting_blood_sugar ? 'High' : 'Normal' }}</td>
                                <td>
                                    @php
                                        $ecgResults = [
                                            0 => 'Normal',
                                            1 => 'ST-T Abnormality',
                                            2 => 'LV Hypertrophy'
                                        ];
                                        echo $ecgResults[$prediction->resting_electrocardiogram] ?? $prediction->resting_electrocardiogram;
                                    @endphp
                                </td>
                                <td>{{ $prediction->max_heart_rate_achieved }}</td>
                                <td>{{ $prediction->exercise_induced_angina ? 'Yes' : 'No' }}</td>
                                <td>{{ $prediction->st_depression }}</td>
                                <td>
                                    @php
                                        $slopes = [
                                            1 => 'Upsloping',
                                            2 => 'Flat',
                                            3 => 'Downsloping'
                                        ];
                                        echo $slopes[$prediction->st_slope] ?? $prediction->st_slope;
                                    @endphp
                                </td>
                                <td>{{ $prediction->num_major_vessels }}</td>
                                <td>
                                    @php
                                        $thalassemiaTypes = [
                                            3 => 'Normal',
                                            6 => 'Fixed Defect',
                                            7 => 'Reversible Defect'
                                        ];
                                        echo $thalassemiaTypes[$prediction->thalassemia] ?? $prediction->thalassemia;
                                    @endphp
                                </td>
                                <td class="{{ $prediction->prediction === 'Disease' ? 'text-danger' : 'text-success' }}">
                                    {{ $prediction->prediction }}
                                </td>
                                <td>{{ number_format($prediction->prediction_score, 2) }}%</td>
                                <td>{{ $prediction->model_used }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection