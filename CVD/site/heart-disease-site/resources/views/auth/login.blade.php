@extends('layouts.app')

@section('content')
    <div class="login-container fade-in">
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn-login">Log in</button>
            </div>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <p class="text-center">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </p>
            @endif
        </form>
    </div>
@endsection