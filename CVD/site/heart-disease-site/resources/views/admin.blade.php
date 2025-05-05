@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Dashboard</h2>
        <div class="card p-4 fade-in">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Date</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Prediction</th>
                        <th>Score</th>
                        <th>Model</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($predictions as $prediction)
                        <tr>
                            <td>{{ $prediction->user_id }}</td>
                            <td>{{ $prediction->created_at->format('Y-m-d') }}</td>
                            <td>{{ $prediction->age }}</td>
                            <td>{{ $prediction->sex }}</td>
                            <td>{{ $prediction->prediction }}</td>
                            <td>{{ number_format($prediction->prediction_score, 2) }}%</td>
                            <td>{{ $prediction->model_used }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection