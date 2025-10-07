@extends('admin.home')

@section('title', 'Admin Appointments')

@section('content')
<div class="container py-5">
    
    <!-- Header with Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h1 class="h2 text-dark fw-bold">All Patient Appointments</h1>
        
        {{-- This button is correctly linked to the appointment creation route --}}
        <a href="{{ route('admin.appointments.create') }}" 
           class="btn btn-primary btn-lg shadow-sm d-flex align-items-center">
            <i class="fas fa-calendar-plus me-2"></i>
            Book New Appointment
        </a>
    </div>

    @if($appointments->isEmpty())
        <div class="alert alert-info border-start border-5 border-info p-4 shadow-sm" role="alert">
            <h4 class="alert-heading fw-bold">No Appointments Found</h4>
            <p>There are currently no appointments in the system. Use the button above to book one now.</p>
        </div>
    @else
        <div class="card shadow-lg rounded-3">
            <div class="card-body p-0 overflow-auto">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-start text-sm fw-semibold text-muted">ID</th>
                            <th scope="col" class="px-4 py-3 text-start text-sm fw-semibold text-muted">Patient</th>
                            <th scope="col" class="px-4 py-3 text-start text-sm fw-semibold text-muted">Doctor</th>
                            <th scope="col" class="px-4 py-3 text-start text-sm fw-semibold text-muted">Date/Time</th>
                            <th scope="col" class="px-4 py-3 text-start text-sm fw-semibold text-muted">Status</th>
                            <th scope="col" class="px-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td class="px-4 py-3 text-sm text-dark fw-medium">
                                #{{ $appointment->id }}
                            </td>
                            <td class="px-4 py-3 text-sm text-dark fw-medium">
                                {{ $appointment->patient->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-muted">
                                <div class="fw-medium text-dark">{{ $appointment->doctor->name ?? 'N/A' }}</div>
                                <div class="small">{{ $appointment->doctor->specialization ?? '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-muted">
                                <div class="fw-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('M d, Y') }}</div>
                                <div class="small">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $status = strtolower($appointment->status);
                                    $badgeClass = match ($status) {
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'completed' => 'bg-info',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end text-sm">
                                {{-- Assuming these routes exist for viewing/editing a specific appointment --}}
                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" 
                                   class="btn btn-sm btn-outline-info me-2">View</a>
                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" 
                                   class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Display pagination links --}}
        <div class="mt-4">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
