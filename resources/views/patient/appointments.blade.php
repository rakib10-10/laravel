@extends('layouts.patient_home')

@section('content')
<style>
    /* Styling from Admin view kept for consistency */
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
    .appointment-container { padding: 40px 20px; max-width: 1200px; margin: auto; }
    .card-title { font-weight: 700; color: #343a40; }
    .table th { background-color: #343a40; color: white; border: none; }
    .status-badge { padding: 5px 12px; border-radius: 50px; font-weight: 600; font-size: 0.8rem; }
    .status-Scheduled { background-color: #17a2b8; color: white; }
    .status-Completed { background-color: #28a745; color: white; }
    .status-Cancelled { background-color: #dc3545; color: white; }
    .btn-create { background-color: #28a745; border-color: #28a745; }
</style>

<div class="appointment-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="card-title"><i class="fas fa-notes-medical me-2"></i> Patient: My Bookings</h1>
        <button class="btn btn-create py-2 px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
            <i class="fas fa-calendar-plus me-1"></i> Book New Appointment
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Appointments Table --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            @if($appointments->isEmpty())
                <div class="alert alert-info m-4">You currently have no bookings. Use the button above to schedule one!</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Booking Date</th>
                                <th>Doctor</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }}</td>
                                    <td>Dr. {{ $appointment->doctor->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($appointment->notes, 40, '...') }}</td>
                                    <td><span class="status-badge status-{{ $appointment->status }}">{{ $appointment->status }}</span></td>
                                    <td>
                                        @if($appointment->status === 'Scheduled')
                                            <form action="{{-- TODO: Add Patient Cancellation Route --}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT') 
                                                <button type="submit" class="btn btn-sm text-danger action-btn" onclick="return confirm('Are you sure you want to cancel this booking?')" title="Cancel Appointment">
                                                    <i class="fas fa-times-circle"></i> Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">No actions available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="mt-4">{{ $appointments->links() }}</div>
</div>

{{-- MODAL: BOOK NEW APPOINTMENT (Patient) --}}
<div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="bookAppointmentModalLabel"><i class="fas fa-calendar-alt me-2"></i> Book New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('patient.appointments.store') }}">
                @csrf
                <div class="modal-body">
                    {{-- Hidden Patient ID is passed from the controller, or grabbed from Auth::user() in the controller --}}
                    <p class="mb-3 text-muted">Booking for: <strong>{{ Auth::user()->name ?? 'You' }}</strong></p>

                    {{-- Doctor Selection --}}
                    <div class="mb-3">
                        <label for="book_doctor_id" class="form-label fw-bold">Select Doctor</label>
                        <select id="book_doctor_id" name="doctor_id" class="form-select" required>
                            <option value="" disabled selected>Choose a Doctor</option>
                            @foreach ($doctors ?? [] as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->name ?? 'Doctor ' . $doctor->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date & Time --}}
                    <div class="mb-3">
                        <label for="book_appointment_date" class="form-label fw-bold">Date & Time</label>
                        <input type="datetime-local" class="form-control" name="appointment_date" id="book_appointment_date" required min="{{ \Carbon\Carbon::now()->addHour()->format('Y-m-d\TH:i') }}">
                    </div>
                    
                    {{-- Notes --}}
                    <div class="mb-3">
                        <label for="book_notes" class="form-label fw-bold">Reason for Visit</label>
                        <textarea class="form-control" name="notes" id="book_notes" rows="3" placeholder="e.g., Annual check-up, persistent cough, follow-up."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success rounded-pill"><i class="fas fa-calendar-check me-1"></i> Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
