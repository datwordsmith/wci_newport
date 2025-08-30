@extends('layouts.auth')

@section('content')

    <form id="adminLoginForm" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label for="email"><i class="fas fa-user me-2"></i>Email</label>

            <div class="invalid-feedback">
                Please provide a valid email address.
            </div>
        </div>

        <div class="form-floating position-relative">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
            <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
            <button type="button" class="password-toggle" onclick="togglePassword()" title="Toggle password visibility" aria-label="Toggle password visibility">
                <i class="fas fa-eye" id="passwordToggleIcon"></i>
            </button>
        </div>

        <div class="remember-me">
            <a href="{{ route('password.request') }}" class="forgot-password" title="Reset Password">
                Forgot Password?
            </a>
        </div>

        <button type="submit" class="btn btn-primary login-btn" id="loginButton">
            <span id="loginButtonText">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </span>
        </button>
    </form>

@endsection
