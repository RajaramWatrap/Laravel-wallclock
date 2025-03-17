@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center mb-3">{{ __('Forgot Password') }}</h3>

        <p class="text-muted text-center">
            {{ __('Forgot your password? No problem. Just enter your email address, and we will send you a password reset link.') }}
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="text-decoration-none text-primary">
                    {{ __('Back to login') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    {{ __('Send Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
