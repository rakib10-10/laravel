@extends('layouts.app')

@section('content')
<style>
    /* Custom styles for aesthetic */
    :root {
        --puc-bg-dark: #1b263b; /* Deep blue/grey */
        --puc-primary-blue: #007bff;
        --puc-dark-blue: #004d99;
    }

    /* Container to handle dark background and centering within the layout's <main> */
    .auth-layout-container {
        background-color: var(--puc-bg-dark);
        min-height: calc(100vh - 56px); /* Adjust height based on navbar height (approx 56px) */
        display: flex;
        align-items: center; 
        justify-content: center; 
        padding: 2rem 1rem;
        margin: -1.5rem auto -1.5rem auto; /* Overcomes the default py-4 of the layout */
        width: 100%;
        font-family: 'Inter', sans-serif;
    }

    /* Card Styling */
    .auth-card {
        background: #ffffff;
        border: none;
        border-radius: 1rem; 
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-width: 450px;
        width: 100%;
        border-top: 6px solid var(--puc-primary-blue);
    }

    .auth-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 55px rgba(0, 0, 0, 0.7);
    }

    /* Header Styling */
    .card-header-styled {
        background: linear-gradient(135deg, var(--puc-dark-blue) 0%, var(--puc-primary-blue) 100%);
        color: white;
        padding: 1.5rem;
        border-top-left-radius: 0.9rem;
        border-top-right-radius: 0.9rem;
        font-weight: 800;
        font-size: 1.5rem;
        text-align: center;
        letter-spacing: 0.5px;
        margin-bottom: 0;
    }

    /* Button Styling */
    .cta-button {
        background-color: var(--puc-primary-blue);
        border: none;
        border-radius: 0.5rem;
        font-weight: 700;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        text-transform: uppercase;
    }

    .cta-button:hover {
        background-color: var(--puc-dark-blue) !important;
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0, 77, 153, 0.5);
    }

    /* Input Styling */
    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: var(--puc-primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    /* Link Styling */
    .auth-link {
        color: var(--puc-primary-blue);
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .auth-link:hover {
        color: var(--puc-dark-blue);
        text-decoration: underline !important;
    }
</style>

<div class="container-fluid auth-layout-container">
    <div class="auth-card">
        <div class="card-header-styled">
            <i class="fas fa-lock me-2"></i>
            PUC MEDIC Portal Login
        </div>
        <div class="card-body p-4 p-md-5">
            {{-- Display Laravel session message (e.g., status from password reset) --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="form-label text-muted fw-bold">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-muted fw-bold">{{ __('Password') }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="remember-me">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none auth-link">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn cta-button">
                        <i class="fas fa-sign-in-alt me-2"></i> {{ __('Log In') }}
                    </button>
                </div>
            </form>

            <div class="text-center small pt-3 border-top">
                @if (Route::has('register'))
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="auth-link text-decoration-none">
                        Register here
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
