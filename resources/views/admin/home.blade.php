<!doctype html>
<html lang="en">

<head>
    <title>PUC Medic Dashboard</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{ asset('images/hospital_logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/netdna.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Modern Color Palette & Typography */
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
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        /* Sidebar styling */
        #sidebarMenu {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background: var(--sidebar-bg);
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid var(--border-color);
            transition: width 0.3s ease, transform 0.3s ease;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
        }

        /* Adjust main content */
        main {
            margin-left: 250px;
            padding: 40px;
            transition: margin-left 0.3s ease;
        }

        /* Sidebar Branding */
        .sidebar-brand {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand img {
            width: 70px;
            height: auto;
            display: block;
            margin: 0 auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand img:hover {
            transform: scale(1.05);
        }

        .sidebar-brand span {
            display: block;
            font-weight: 700;
            margin-top: 0.75rem;
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        /* Sidebar links */
        #sidebarMenu .nav-link {
            color: var(--text-light);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
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
            box-shadow: var(--shadow-sm);
            transform: translateX(0); /* Reset transform for active link */
        }

        #sidebarMenu .nav-link i {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: 8px;
        }

        .dropdown-item {
            color: var(--text-dark);
            padding: 10px 20px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .dropdown-item i {
            margin-right: 10px;
        }

        /* Main content container */
        .content-container {
            padding: 20px;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            min-height: 80vh;
        }

        h2.page-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <nav id="sidebarMenu" class="d-md-block sidebar">
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

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="content-container">
                    <h2 class="page-title">Dashboard Overview</h2>
                    @yield('dashboard')
                    @yield('patient')
                    @yield('doctors')
                    @yield('medicines')
                    @yield('reports')
                    @yield('appointment')
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>