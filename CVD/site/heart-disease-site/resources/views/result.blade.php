@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Prediction Result</h2>
        <div class="card p-4 fade-in">
            <div class="alert {{ $data['prediction'] === 'Heart Disease' ? 'alert-danger' : 'alert-success' }}"
                role="alert">
                Prediction: {{ $data['prediction'] }}
            </div>
            <p><strong>Probability of Heart Disease:</strong> {{ number_format($data['probability'] * 100, 2) }}%</p>
            <p><strong>AI Model:</strong> {{ $data['model'] }}</p>
            <a href="{{ route('prediction') }}" class="btn btn-primary w-100">Back to Prediction</a>
        </div>
    </div>
@endsection