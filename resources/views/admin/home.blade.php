<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'PUC Medic Dashboard') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Vite (for Laravel assets like app.js, app.scss) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --accent-color: #28a745;
            --background-light: #f4f7f9;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-dark: #333;
            --text-light: #666;
            --border-color: #e9ecef;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        /* Sidebar */
        #sidebarMenu {
            position: fixed;
            top: 56px; /* navbar height */
            bottom: 0;
            left: 0;
            width: 250px;
            background: var(--sidebar-bg);
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
        }
        main {
            margin-left: 250px;
            margin-top: 56px; /* navbar height */
            padding: 40px;
        }
        .sidebar-brand { text-align: center; margin-bottom: 2rem; }
        .sidebar-brand img { width: 70px; display: block; margin: 0 auto; }
        .sidebar-brand span { display: block; font-weight: 700; margin-top: 0.75rem; font-size: 1.5rem; }
        #sidebarMenu .nav-link {
            color: var(--text-light);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        #sidebarMenu .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--background-light);
            transform: translateX(5px);
        }
        #sidebarMenu .nav-link.active {
            color: #fff !important;
            background-color: var(--primary-color) !important;
        }
        #sidebarMenu .nav-link i { margin-right: 15px; }
        .content-container {
            padding: 20px;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            min-height: 80vh;
        }
        h2.page-title { color: var(--primary-color); margin-bottom: 20px; font-weight: 600; }
    </style>
</head>

<body>
    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('PUC MEDIC', 'PUC MEDIC') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto"></ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <nav id="sidebarMenu">
        <div class="sidebar-sticky pt-3">
            <div class="sidebar-brand">
                <img src="{{ asset('images/hospital_logo.png') }}" alt="Hospital Logo">
                <span>PUC MEDIC</span>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.patient') ? 'active' : '' }}"
                       href="{{ route('admin.patient') }}">
                        <i class="fa-solid fa-hospital-user"></i> Patients
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-user-doctor"></i> Doctors
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{ Request::routeIs('admin.doctors.index') ? 'active' : '' }}"
                           href="{{ route('admin.doctors.index') }}">
                            <i class="fa-solid fa-user-doctor"></i> All Doctors
                        </a>
                        <a class="dropdown-item {{ Request::routeIs('admin.doctors.create') ? 'active' : '' }}"
                           href="{{ route('admin.doctors.create') }}">
                            <i class="fa-solid fa-user-plus"></i> Add New Doctor
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.medicines.index') ? 'active' : '' }}"
                       href="{{ route('admin.medicines.index') }}">
                        <i class="fa-solid fa-pills"></i> Medicines
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.reports.index') ? 'active' : '' }}"
                       href="{{ route('admin.reports.index') }}">
                        <i class="fa-solid fa-chart-line"></i> Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.appointment') ? 'active' : '' }}"
                       href="{{ route('admin.appointment') }}">
                        <i class="fa-solid fa-layer-group"></i> Appointment
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        <div class="content-container">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
