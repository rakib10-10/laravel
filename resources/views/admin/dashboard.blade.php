@extends('admin.home')

@section('content')
<style>
    .card i {
      font-size: 2rem;
    }
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
      margin-top: 20px;
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
    .completed { background-color: #28a745; }
    .pending { background-color: #f0ad4e; }
    .cancelled { background-color: #dc3545; }
    .confirmed { background-color: #17a2b8; }
    .day-badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        font-weight: bold;
    }
    .day-monday { background-color: #e3f2fd; color: #1976d2; }
    .day-tuesday { background-color: #e8f5e8; color: #388e3c; }
    .day-wednesday { background-color: #fff3e0; color: #f57c00; }
    .day-thursday { background-color: #fce4ec; color: #c2185b; }
    .day-friday { background-color: #f3e5f5; color: #7b1fa2; }
    .day-saturday { background-color: #e0f2f1; color: #00796b; }
    .day-sunday { background-color: #fff8e1; color: #ff8f00; }
</style>

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
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-calendar-check text-secondary"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total Appointment</h6>
                  <span class="text-muted">{{ $totalAppointments ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-hospital-user color-lightblue"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total<br> Patients</h6>
                  <span class="text-muted">{{ $totalPatients ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-user-doctor color-light-orange"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Total Doctors</h6>
                  <span class="text-muted">{{ $totalDoctors ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-calendar-day color-careys-pink"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Today's<br> Appointments</h6>
                  <span class="text-muted">{{ $todayAppointments ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-clock color-lavender-purple"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Pending<br> Appointments</h6>
                  <span class="text-muted">{{ $pendingAppointments ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
              <div class="card">
                <div class="card-body text-center">
                  <i class="fa-solid fa-check-circle color-light-success"></i>
                  <h6 class="mt-3 mb-0 fw-bold small-14">Completed<br> Appointments</h6>
                  <span class="text-muted">{{ $completedAppointments ?? 0 }}</span>
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
    <h2>Recent Appointments</h2>
    
    @if(isset($recentAppointments) && $recentAppointments->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Patient Name</th>
          <th>Doctor</th>
          <th>Appointment Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentAppointments as $appointment)
        <tr>
          <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
          <td>Dr. {{ $appointment->doctor->name ?? 'N/A' }}</td>
          
          <td>{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('m-d-Y') : 'N/A' }}</td>
          <td>{{ $appointment->start_time ?? 'N/A' }}</td>
          <td>{{ $appointment->end_time ?? 'N/A' }}</td>
          <td>
            <span class="status 
              @if($appointment->status == 'completed') completed
              @elseif($appointment->status == 'confirmed') confirmed
              @elseif($appointment->status == 'cancelled') cancelled
              @else pending @endif">
              {{ ucfirst($appointment->status ?? 'pending') }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="alert alert-info text-center">
        No appointments found.
    </div>
    @endif
</div>


@endsection