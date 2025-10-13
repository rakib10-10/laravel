<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'PUC MEDIC') }} | Home</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ8YyI3/GAp5/1XyvF65/Sgq9yVz2+K+sYw7JzD+2A7D+J17XoF505G5kG5yL9Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<style>
    :root {
        --puc-blue: #004d99;
        --puc-light-blue: #007bff;
        --puc-dark: #212529;
        --puc-bg-dark: #1b263b; /* Deep blue/grey for background */
        --puc-accent: #28a745; /* Green for key actions */
    }

    /* Full page hero setup */
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Figtree', sans-serif;
        overflow-x: hidden;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--puc-bg-dark) 0%, var(--puc-dark) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff; /* White text on dark background */
        position: relative;
    }

    /* Subtle background pattern/overlay */
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: radial-gradient(circle at 100% 100%, rgba(255, 255, 255, 0.05), transparent 70%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 2rem;
        max-width: 800px;
    }

    .logo-title {
        font-size: 4rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--puc-light-blue);
        text-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
        margin-bottom: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .logo-title {
            font-size: 3rem;
        }
    }

    .tagline {
        font-size: 1.5rem;
        font-weight: 300;
        margin-bottom: 3rem;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Styles for the new top Navbar */
    .navbar {
        background-color: rgba(27, 38, 59, 0.85); /* Semi-transparent background */
        backdrop-filter: blur(5px);
        position: absolute;
        width: 100%;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }
    .navbar .nav-link {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
    }
    .navbar .nav-link:hover {
        color: var(--puc-light-blue);
    }
    .navbar-brand {
        color: var(--puc-light-blue) !important;
        font-weight: 700;
    }

    .login-btn, .register-btn {
        padding: 0.8rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 50px; /* Pill shape */
        transition: all 0.3s ease;
        margin: 0.5rem;
    }

    .login-btn {
        background-color: var(--puc-light-blue);
        border-color: var(--puc-light-blue);
        box-shadow: 0 8px 15px rgba(0, 123, 255, 0.4);
    }
    .login-btn:hover {
        background-color: var(--puc-blue);
        border-color: var(--puc-blue);
        transform: translateY(-2px);
    }

    .register-btn {
        background-color: transparent;
        border: 2px solid white;
        color: white;
    }
    .register-btn:hover {
        background-color: white;
        color: var(--puc-bg-dark);
        border-color: white;
    }

    /* Remove the old top-right auth-nav since we have a dedicated Navbar now */
    .auth-nav {
        display: none !important;
    }

</style>

</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
             <i class="fas fa-hospital-alt me-2"></i> PUC MEDIC
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light btn-sm ms-lg-3" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="hero-section">

    <div class="hero-content">
        <a href="{{ url('/') }}" class="text-white text-decoration-none">
            <i class="fas fa-stethoscope fa-3x mb-3" style="color: var(--puc-light-blue);"></i>
        </a>
        <h1 class="logo-title">PUC MEDIC</h1>
        <p class="tagline">
            The integrated platform connecting patients and healthcare providers for seamless care management.
        </p>

        @if (Route::has('login'))
            <div class="mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn login-btn text-white">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn login-btn text-white">
                        Patient/Admin Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn register-btn">
                            Create Account
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>