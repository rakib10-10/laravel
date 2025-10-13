@extends('layouts.doctor_home')

@section('content')

<div class="py-3">
<div class="card shadow-lg border-0">
<div class="card-header" style="background-color: var(--primary-color); color: white;">
<h4 class="mb-0">Doctor Dashboard</h4>
</div>
<div class="card-body">
<p class="lead">Welcome back,Doctor {{ $doctor->name ?? Auth::user()->name ?? 'Doctor' }}!</p>
<p>This dashboard provides an overview of your upcoming appointments, patient records, and schedule management tools.</p>

<div class="row mt-4">
    
    <div class="col-md-4 mb-3">
        <div class="card text-center bg-light border-start border-success border-4 h-100">
            <div class="card-body">
                <h5 class="card-title" style="color: var(--primary-color);">Today's Appointments</h5>
                <p class="h1 mb-0 fw-bold">7</p>
                <p class="text-muted">patients scheduled</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-center bg-light border-start border-primary border-4 h-100">
            <div class="card-body">
                <h5 class="card-title text-primary">Total Patients</h5>
                <p class="h1 mb-0 fw-bold">215</p>
                <p class="text-muted">in your care</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-center bg-light border-start border-warning border-4 h-100">
            <div class="card-body">
                <h5 class="card-title text-warning">Pending Confirmations</h5>
                <p class="h1 mb-0 fw-bold">3</p>
                <p class="text-muted">appointments</p>
            </div>
        </div>
    </div>
</div>

{{-- Upcoming Appointments Table (Static Data) --}}
<h5 class="mt-5 mb-3 border-bottom pb-2" style="color: var(--primary-color);">Upcoming Appointments (Next 10)</h5>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Patient</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- Static Appointment Data --}}
            <tr>
                <td>Nov 10, 2025</td>
                <td>10:00 AM</td>
                <td>John Doe</td>
                <td>Routine annual checkup</td>
                <td>
                    <span class="badge bg-success text-white">Confirmed</span>
                </td>
            </tr>
            <tr>
                <td>Nov 10, 2025</td>
                <td>11:30 AM</td>
                <td>Jane Eire</td>
                <td>Sudden onset of fever and cough</td>
                <td>
                    <span class="badge bg-warning text-black">Pending</span>
                </td>
            </tr>
            <tr>
                <td>Nov 11, 2025</td>
                <td>09:00 AM</td>
                <td>Mark Rutter</td>
                <td>Post-surgery follow-up</td>
                <td>
                    <span class="badge bg-success text-white">Confirmed</span>
                </td>
            </tr>
            <tr>
                <td>Nov 11, 2025</td>
                <td>14:00 PM</td>
                <td>Alicia Keys</td>
                <td>Consultation for chronic pain</td>
                <td>
                    <span class="badge bg-success text-white">Confirmed</span>
                </td>
            </tr>
            <tr>
                <td>Nov 12, 2025</td>
                <td>08:30 AM</td>
                <td>Tyler Durden</td>
                <td>Blood test results review</td>
                <td>
                    <span class="badge bg-warning text-black">Pending</span>
                </td>
            </tr>
            {{-- End Static Appointment Data --}}
        </tbody>
    </table>
</div>
{{-- End Upcoming Appointments Table --}}

<div class="list-group mt-4">
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <span style="color: var(--primary-color);">View All Appointments</span>
        <i class="fas fa-calendar-day text-success"></i>
    </a>
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <span style="color: var(--primary-color);">Access Patient Records</span>
        <i class="fas fa-notes-medical text-success"></i>
    </a>
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <span style="color: var(--primary-color);">Update Working Schedule</span>
        <i class="fas fa-clock text-success"></i>
    </a>
</div>

</div>

</div>
</div>
@endsection