@extends('layouts.app')

@section('content')
    <style>
       :root {
    /* Background and Primary Dark Colors */
    --puc-bg-dark: #1b263b;        /* Deep blue/grey for background */
    
    /* Primary Blue Accents (e.g., for Login links) */
    --puc-primary-blue: #007bff;   /* Standard Bootstrap-like blue */
    --puc-dark-blue: #004d99;      /* Darker blue for hover/accents */
    
    /* Primary Green Accents (e.g., for Registration) */
    --puc-primary-green: #28a745;  /* Standard Bootstrap-like green */
    --puc-dark-green: #1e7e34;     /* Darker green for hover/gradients */
}
        

        /* Container to handle dark background and centering within the layout&#39;s &lt;main&gt; */
        .auth-layout-container {
            background-color: var(--puc-bg-dark);
            min-height: calc(100vh - 56px);
            /* Adjust height based on navbar height (approx 56px) */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            margin: -1.5rem auto -1.5rem auto;
            /* Overcomes the default py-4 of the layout */
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

        .card-header-styled {
        background: linear-gradient(135deg, var(--puc-dark-blue) 0%, var(--puc-primary-blue) 100%);
        color: rgb(231, 235, 240);
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
            /* Use dark green for hover */
            background-color: var(--puc-dark-green) !important;
            transform: scale(1.02);
            /* Darker green shadow */
            box-shadow: 0 6px 15px rgba(30, 126, 52, 0.5);
        }

        /* Input Styling */
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #a4c3e1;
        }

        .form-control:focus {
            /* Green focus border */
            border-color: var(--puc-primary-green);
            /* Green focus shadow */
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }

        /* Link Styling - Use blue for the &quot;Log In&quot; link for contrast/consistency */
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
                <i class="fas fa-user-plus me-2"></i>
                PUC MEDIC Account Registration
            </div>
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label text-muted fw-bold">{{ __('Full Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="John Doe" value="{{ old('name') }}" required autocomplete="name"
                            autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted fw-bold">{{ __('Email Address') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="you@example.com" value="{{ old('email') }}" required
                            autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label text-muted fw-bold">{{ __('Password') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="••••••••" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <label for="password-confirm"
                            class="form-label text-muted fw-bold">{{ __('Confirm Password') }}</label>
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation"
                            placeholder="••••••••" required autocomplete="new-password">
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn cta-button">
                            <i class="fas fa-user-plus me-2"></i> {{ __('Register Account') }}
                        </button>
                    </div>
                </form>

                <div class="text-center small pt-3 border-top">
                    @if (Route::has('login'))
                        Already registered?
                        <a href="{{ route('login') }}" class="auth-link text-decoration-none">
                            Log In here
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
