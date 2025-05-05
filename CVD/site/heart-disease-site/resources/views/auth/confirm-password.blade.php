@extends('layouts.app')

@section('content')
    <div class="auth-container fade-in">
        <h2>Confirm Password</h2>
        <p class="text-center">Please confirm your password to continue.</p>

        @if (session('status'))
            <div class="alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autofocus>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn-auth">Confirm</button>
            </div>
        </form>

        <p class="text-center">
            <a href="{{ route('login') }}" class="auth-link">Back to Login</a>
        </p>
    </div>
@endsection