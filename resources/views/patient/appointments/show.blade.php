@extends('layouts.patient_home')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white border-bottom border-primary">
                    <h2 class="h5 mb-0 fw-bold">Appointment Details</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4 pb-2 border-bottom">
                        <h3 class="h4 fw-bold text-dark">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</h3>
                        <p class="text-muted mb-1">{{ $appointment->doctor->specialty ?? 'Specialty not listed' }}</p>
                    </div>

                    {{-- Status Section --}}
                    @php
                        $statusLower = strtolower($appointment->status);
                        $statusText = ucfirst($statusLower);
                        $statusClass = [
                            'pending' => 'text-bg-warning',
                            'confirmed' => 'text-bg-primary',
                            'completed' => 'text-bg-success',
                            'cancelled' => 'text-bg-danger',
                        ][$statusLower] ?? 'text-bg-secondary';
                    @endphp
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3 {{ $statusClass }}">
                        <strong class="text-white">{{ $statusText }}</strong>
                        <span class="text-white fw-bold">Status:</span>
                    </div>

                    {{-- Date and Time --}}
                    <div class="row mb-3">
                        <div class="col-4 fw-bold text-muted">Date:</div>
                        <div class="col-8 text-dark">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4 fw-bold text-muted">Time Slot:</div>
                        <div class="col-8 text-dark">
                            @if (empty($appointment->start_time) || empty($appointment->end_time))
                                <span class="text-primary fw-semibold">TBA - Awaiting Time Slot Confirmation</span>
                            @else
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                            @endif
                        </div>
                    </div>

                    {{-- Reason/Notes --}}
                    <div class="mb-4">
                        <strong class="text-muted d-block mb-2">Reason for Appointment:</strong>
                        <div class="p-3 bg-light rounded-3 border">
                            {{ $appointment->reason ?? 'No reason provided.' }}
                        </div>
                    </div>

                    {{-- Actions/Back Button --}}
                    <div class="d-flex justify-content-end pt-3 border-top">
                        <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary me-2">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                        </a>

                        {{-- Cancel button is only active if the appointment is pending --}}
                        @if ($statusLower == 'pending')
                            <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-times me-1"></i> Cancel Appointment
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
