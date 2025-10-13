@extends('admin.home')

@section('title', 'Edit Appointment')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h1 class="h2 text-dark fw-bold">
            <i class="fas fa-edit me-2 text-primary"></i>
            Edit Appointment #{{ $appointment->id }}
        </h1>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="fas fa-arrow-left me-2"></i>
            Back to List
        </a>
    </div>

    <div class="card shadow-lg rounded-3">
        <div class="card-body p-4 p-md-5">
            
            {{-- Form for updating the appointment. The method is POST but includes @method('PUT') for Laravel's routing. --}}
            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h3 class="card-title mb-4 text-center text-muted">Update Appointment Details</h3>

                {{-- Row 1: Patient and Doctor Selection --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="patient_id" class="form-label fw-semibold">Patient Name</label>
                        <select id="patient_id" name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">Select Patient</option>
                            {{-- Assume $patients is passed from the controller, e.g., Patient::all() --}}
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" 
                                    {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} (ID: {{ $patient->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="doctor_id" class="form-label fw-semibold">Doctor Name</label>
                        <select id="doctor_id" name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                            <option value="">Select Doctor</option>
                            {{-- Assume $doctors is passed from the controller, e.g., Doctor::all() --}}
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" 
                                    {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} ({{ $doctor->specialization ?? 'General' }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: Date, Time, and Status --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="appointment_date" class="form-label fw-semibold">Date</label>
                        {{-- Extract only the date part for the date input type --}}
                        @php $currentDate = \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d'); @endphp
                        <input type="date" id="appointment_date" name="appointment_date" 
                               class="form-control @error('appointment_date') is-invalid @enderror" 
                               value="{{ old('appointment_date', $currentDate) }}" required>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="appointment_time" class="form-label fw-semibold">Time</label>
                         {{-- Extract only the time part for the time input type --}}
                        @php $currentTime = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i'); @endphp
                        <input type="time" id="appointment_time" name="appointment_time" 
                               class="form-control @error('appointment_time') is-invalid @enderror" 
                               value="{{ old('appointment_time', $currentTime) }}" required>
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            {{-- Define standard statuses. You can pass these via controller if needed. --}}
                            @php 
                                $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
                            @endphp
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}" 
                                    {{ old('status', $appointment->status) == $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Notes/Reason --}}
                <div class="mb-5">
                    <label for="reason" class="form-label fw-semibold">Reason for Appointment / Notes</label>
                    <textarea id="reason" name="reason" rows="3" 
                              class="form-control @error('reason') is-invalid @enderror" 
                              placeholder="Describe the reason for the appointment or add any administrative notes.">{{ old('reason', $appointment->reason ?? '') }}</textarea>
                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm w-100 w-md-auto">
                        <i class="fas fa-save me-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
