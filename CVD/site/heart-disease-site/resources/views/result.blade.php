@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Prediction Result</h2>
        <div class="card p-4 fade-in">
            <div class="alert {{ $prediction == 'Disease' ? 'alert-danger' : 'alert-success' }}" role="alert">
                Prediction: {{ $prediction }}
            </div>
            <p><strong>Prediction Score:</strong> {{ number_format($score, 2) }}%</p>
            <p><strong>AI Model:</strong> {{ $model }}</p>
            <p><strong>Model Accuracy:</strong> {{ number_format($accuracy, 2) }}%</p>
            <a href="{{ route('prediction') }}" class="btn btn-primary w-100">Back to Prediction</a>
        </div>
    </div>
@endsection