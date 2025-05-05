@extends('layouts.app')

@section('content')
    <div class="auth-container fade-in">
        <h2>Reset Password</h2>
        <p class="text-center">Enter your new password.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Hidden Email -->
            <input type="hidden" name="email" value="{{ $request->email }}">

            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- New Password -->
            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" name="password" required autofocus>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn-auth">Reset Password</button>
            </div>
        </form>

        <p class="text-center">
            <a href="{{ route('login') }}" class="auth-link">Back to Login</a>
        </p>
    </div>
@endsection