@extends('layouts.app')

@section('content')
    <div class="auth-container fade-in">
        <h2>Verify Your Email Address</h2>
        <p class="text-center">A verification link has been sent to your email address.</p>

        @if (session('status'))
            <div class="alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="form-group">
                <button type="submit" class="btn-auth">Resend Verification Email</button>
            </div>
        </form>

        <p class="text-center">
            <a href="{{ route('login') }}" class="auth-link">Back to Login</a>
        </p>
    </div>
@endsection