<!doctype html>
<html lang="en">
<head>
  <title>PUC Medic Dashboard</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="{{ asset('images/hospital_logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* Sidebar styling */
    #sidebarMenu {
      position: fixed;
      top: 0;               /* Start at the very top */
      bottom: 0;
      left: 0;
      width: 220px;         /* Sidebar width */
      background: #f8f9fa;  /* Light gray */
      padding-top: 1rem;
      overflow-y: auto;
      border-right: 1px solid #dee2e6;
    }

    /* Adjust main content to the right of sidebar */
    main {
      margin-left: 220px; /* Match sidebar width */
      padding: 20px;
    }

    /* Sidebar Branding */
    .sidebar-brand {
      text-align: center;
      margin-bottom: 1rem;
    }
    .sidebar-brand img {
      width: 50px;
      height: 50px;
      display: block;
      margin: 0 auto;
    }
    .sidebar-brand span {
      display: block;
      font-weight: bold;
      margin-top: 0.5rem;
      font-size: 1.2rem;
    }

    /* Sidebar links */
    #sidebarMenu .nav-link {
      color: #495057;
      padding: 0.5rem 1rem;
    }
    #sidebarMenu .nav-link:hover {
      color: #007bff;
    }
    #sidebarMenu .nav-link.active {
      color: #fff !important;
      background-color: #007bff !important;
      border-radius: 4px;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
      <div class="sidebar-sticky pt-3">
        
        <!-- Logo + Name -->
        <div class="sidebar-brand">
          <img src="{{ asset('images/hospital_logo.png') }}" alt="Hospital Logo">
          <span>PUC MEDIC</span>
        </div>

        <!-- Sidebar Menu -->
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
              <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('admin.patient') ? 'active' : '' }}" href="{{ route('admin.patient') }}">
              <i class="fa-solid fa-hospital-user"></i> Patients
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('admin.doctors') ? 'active' : '' }}" href="{{ route('admin.doctors') }}">
              <i class="fa-solid fa-user-doctor"></i> Doctors
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('admin.medicines') ? 'active' : '' }}" href="{{ route('admin.medicines') }}">
              <i class="fa-solid fa-pills"></i> Medicines
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
              <i class="fa-solid fa-chart-line"></i> Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('admin.appointment') ? 'active' : '' }}" href="{{ route('admin.appointment') }}">
              <i class="fa-solid fa-layer-group"></i> Appointment
            </a>
          </li>
        </ul>

      </div>
    </nav>

    <!-- Main Content -->
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      @yield('dashboard')
      @yield('patient')
      @yield('doctors')
      @yield('medicines')
      @yield('reports')
      @yield('appointment')
    </main>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
