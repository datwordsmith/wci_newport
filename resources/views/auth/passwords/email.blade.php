@extends('layouts.auth')

@section('content')

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <p class="mb-3">Enter your email address and we'll send you a link to reset your password.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <label for="email"><i class="fas fa-user me-2"></i>Email</label>

                <div class="invalid-feedback">
                    Please provide a valid email address.
                </div>
            </div>
            <button type="submit" class="btn btn-primary login-btn" id="loginButton">
                <span id="loginButtonText">
                    <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                </span>
            </button>
        </form>

@endsection
