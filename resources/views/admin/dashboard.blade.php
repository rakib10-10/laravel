@extends('admin.home')
<!-- IcoFont CSS -->
<style>
    .card i {
      font-size: 2rem;
    }
    /* Optional custom colors */
    .color-lightblue { color: #4ea8de; }
    .color-light-orange { color: #ff9f43; }
    .color-careys-pink { color: #e5989b; }
    .color-lavender-purple { color: #b388eb; }
    .color-light-success { color: #51cf66; }
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7f8;
      margin: 0;
      padding: 20px;
    }

    .appointments-container {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      padding: 15px;
      margin: auto;
    }

    h2 {
      color: #d97726;
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
    }

    th {
      background-color: #f9f9f9;
      color: #333;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .status {
      padding: 5px 12px;
      border-radius: 5px;
      font-size: 0.9em;
      font-weight: bold;
      color: white;
    }

    .completed {
      background-color: #28a745;
    }

    .pending {
      background-color: #f0ad4e;
    }

    .cancelled {
      background-color: #dc3545;
    }
  </style>


@section('dashboard')
<h1 class="text-center">Dashboard</h1>

<div class="container mt-6">
  <div class="row g-3 mb-3 row-deck">
    <div class="col-lg-12 col-xl-6">
      <div class="card">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
          <h6 class="mb-0 fw-bold text-center">Hospitality Status</h6>
        </div>
        <div class="card-body">
          <div class="row g-3 row-deck">
            
            <div class="col-md-4 col-sm-5">
              <div class="card" >
                <div class="card-body text-center">
                  <i class="fa-solid fa-calendar-check text-secondary"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total Appointment</h6>
                  <span class="text-muted">400</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card" >
                <div class="card-body text-center">
                  <i class="fa-solid fa-hospital-user color-lightblue"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total<br> Patients</h6>
                  <span class="text-muted">117</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-user-doctor color-light-orange"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Patients per Doctor</h6>
                  <span class="text-muted">16</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-bed color-careys-pink" color-></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Available Bed</h6>
                  <span class="text-muted">144</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-user-md color-lavender-purple"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total Doctor</h6>
                  <span class="text-muted">200</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-user-nurse color-light-success"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total Nurse</h6>
                  <span class="text-muted">84</span>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="appointments-container">
    <h2>Appointments</h2>
    <table>
      <thead>
        <tr>
          <th>Patient Name</th>
          <th>Doctor</th>
          <th>Check-Up</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Rajesh</td>
          <td>Manoj Kumar</td>
          <td>Dental</td>
          <td>12-10-2018</td>
          <td>12:10PM</td>
          <td><span class="status completed">Completed</span></td>
        </tr>
        <tr>
          <td>Riya</td>
          <td>Daniel</td>
          <td>Ortho</td>
          <td>12-10-2018</td>
          <td>1:10PM</td>
          <td><span class="status pending">Pending</span></td>
        </tr>
        <tr>
          <td>Siri</td>
          <td>Daniel</td>
          <td>Ortho</td>
          <td>12-10-2018</td>
          <td>1:30PM</td>
          <td><span class="status cancelled">Cancelled</span></td>
        </tr>
        <tr>
          <td>Rajesh</td>
          <td>Manoj Kumar</td>
          <td>Dental</td>
          <td>12-10-2018</td>
          <td>12:10PM</td>
          <td><span class="status completed">Completed</span></td>
        </tr>
        <tr>
          <td>Riya</td>
          <td>Daniel</td>
          <td>Ortho</td>
          <td>12-10-2018</td>
          <td>1:10PM</td>
          <td><span class="status pending">Pending</span></td>
        </tr>
        <tr>
          <td>Siri</td>
          <td>Daniel</td>
          <td>Ortho</td>
          <td>12-10-2018</td>
          <td>1:30PM</td>
          <td><span class="status cancelled">Cancelled</span></td>
        </tr>
      </tbody>
    </table>
  </div>

    
@endsection