@extends('admin.home')

@section('content')
<div class="card shadow-sm p-4">
    <div class="text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
        </div>
        
        <h2 class="text-success mb-3">Appointment Booked Successfully!</h2>
        
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Appointment Details</h5>
                <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
                <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
                <p><strong>Day:</strong> {{ $appointment->available_day }}</p>
                <p><strong>Time Slot:</strong> {{ $appointment->time_slot }}</p>
                <p><strong>Status:</strong> <span class="badge bg-warning">{{ $appointment->status }}</span></p>
                @if($appointment->notes)
                    <p><strong>Notes:</strong> {{ $appointment->notes }}</p>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
                Book Another Appointment
            </a>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                View All Appointments
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection