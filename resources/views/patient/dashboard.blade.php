@extends('layouts.patient_home')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <h1 class="text-3xl fw-bolder text-dark mb-4">Welcome, {{ $user->name }}</h1>
            
            <!-- Next Appointment Card -->
            <div class="card shadow-lg mb-4 border-primary">
                <div class="card-header bg-primary-subtle text-primary fw-bold fs-5 d-flex align-items-center">
                    <i class="fa-solid fa-calendar-check me-3"></i> Next Appointment
                </div>
                <div class="card-body text-secondary">
                    @if($nextAppointment)
                        @php
                            $nextStatusLower = strtolower($nextAppointment->status);
                            $nextBadgeClass = match($nextStatusLower) {
                                'confirmed' => 'bg-success',
                                'pending' => 'bg-warning',
                                default => 'bg-info',
                            };
                        @endphp
                        <div class="mb-2">
                            <span class="fw-bold text-dark me-2">Doctor:</span> 
                            {{-- ADDED NULL-SAFE OPERATOR to prevent crashes if Doctor model is missing --}}
                            <span class="fs-5">Dr. {{ $nextAppointment->doctor?->name ?? 'Unknown Doctor' }}</span>
                        </div>
                        {{-- Displaying the Reason for the appointment --}}
                        <div class="mb-2">
                            <span class="fw-bold text-dark me-2">Reason:</span> 
                            <span class="text-secondary">{{ $nextAppointment->reason ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-dark me-2">Date & Time:</span> 
                                <span class="fs-5 text-primary font-monospace">
                                    {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d M Y, h:i A') }}
                                </span>
                            </div>
                            <span class="badge rounded-pill {{ $nextBadgeClass }} ms-2 text-uppercase fs-6">
                                {{ $nextAppointment->status }}
                            </span>
                        </div>
                        {{-- Link to view the specific appointment details (CORRECTED ROUTE) --}}
                        <a href="{{ route('patient.appointments.show', $nextAppointment->id) }}" class="btn btn-link p-0 mt-2 text-decoration-none text-primary fw-semibold">
                            View Details &rarr;
                        </a>
                    @else
                        <p class="text-muted fst-italic">You have no upcoming appointments.</p>
                        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary btn-sm mt-3 shadow">
                            Book an Appointment
                        </a>
                    @endif
                </div>
            </div>

            <!-- Recent Activities Card (Existing) -->
            <div class="card shadow-lg mb-4">
                <div class="card-header fw-bold fs-5 text-dark d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-history me-3"></i> Recent Activities</span>
                    {{-- Displays the count of recent activities loaded --}}
                    <span class="badge bg-secondary rounded-pill">{{ $recentActivities->count() }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    @if($recentActivities->count())
                        @foreach($recentActivities as $appointment)
                            @php
                                $statusLower = strtolower($appointment->status);
                                $badgeClass = match($statusLower) {
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-warning',
                                };
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">
                                    <span class="fw-medium">Appointment</span> with 
                                    {{-- ADDED NULL-SAFE OPERATOR --}}
                                    <span class="fw-bold text-dark">Dr. {{ $appointment->doctor?->name ?? 'Unknown Doctor' }}</span>
                                </span>
                                <span class="text-sm text-muted">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                    {{-- Status badge based on Bootstrap colors --}}
                                    <span class="badge rounded-pill {{ $badgeClass }} ms-2 text-uppercase">
                                        {{ $appointment->status }}
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            <p class="text-muted fst-italic mb-0">No recent activities found.</p>
                        </li>
                    @endif
                </ul>
            </div>
            
            <!-- NEW SECTION: All Upcoming Appointments -->
            <div class="card shadow-lg mt-4">
                <div class="card-header fw-bold fs-5 text-primary d-flex align-items-center justify-content-between bg-primary-subtle border-primary">
                    <span><i class="fa-solid fa-calendar-days me-3"></i> All Upcoming Appointments</span>
                    @if(isset($upcomingAppointments))
                    <span class="badge bg-primary rounded-pill">{{ $upcomingAppointments->count() }}</span>
                    @endif
                </div>
                <ul class="list-group list-group-flush">
                    @if(isset($upcomingAppointments) && $upcomingAppointments->count())
                        @foreach($upcomingAppointments as $appointment)
                            @php
                                $statusLower = strtolower($appointment->status);
                                $badgeClass = match($statusLower) {
                                    'confirmed' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    default => 'bg-info', 
                                };
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</span> with
                                    {{-- ADDED NULL-SAFE OPERATOR --}}
                                    <span class="fw-bold text-dark">Dr. {{ $appointment->doctor?->name ?? 'Unknown Doctor' }}</span>
                                </span>
                                <div>
                                    <span class="badge rounded-pill {{ $badgeClass }} me-2 text-uppercase">
                                        {{ $appointment->status }}
                                    </span>
                                    <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="btn btn-sm btn-outline-info">Details</a>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            <p class="text-muted fst-italic mb-0">No upcoming confirmed or pending appointments found.</p>
                        </li>
                    @endif
                </ul>
            </div>
            
        </div>
    </div>
</div>
@endsection
