@extends('layouts.app')

@section('content')
    <div class="hero-section">
        <div class="hero-content">
            <span class="highlight-box" style="color: white;">Predict Heart Dis</span>
            <span class="">ease Risk with AI</span>
            <p>Advanced AI Models for Your Health</p>
            @auth
                <a href="{{ route('prediction') }}" class="btn btn-primary">Get Started</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
            @endauth
        </div>
        <div class="wave"></div>
    </div>
@endsection