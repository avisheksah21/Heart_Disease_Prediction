@extends('layouts.app')

@section('content')
    <div class="auth-container fade-in">
        <h2>Forgot Password</h2>
        <p class="text-center">Enter your email address to receive a password reset link.</p>

        @if (session('status'))
            <div class="alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn-auth">Send Reset Link</button>
            </div>
        </form>

        <p class="text-center">
            <a href="{{ route('login') }}" class="auth-link">Back to Login</a>
        </p>
    </div>
@endsection