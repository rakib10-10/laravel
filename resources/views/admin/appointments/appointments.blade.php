{{-- @extends('admin.home')

@section('content')
<style>
    /* Styling from previous unified view kept for consistency */
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
    .appointment-container { padding: 40px 20px; max-width: 1200px; margin: auto; }
    .card-title { font-weight: 700; color: #343a40; }
    .table th { background-color: #343a40; color: white; border: none; }
    .status-badge { padding: 5px 12px; border-radius: 50px; font-weight: 600; font-size: 0.8rem; }
    .status-Scheduled { background-color: #17a2b8; color: white; }
    .status-Completed { background-color: #28a745; color: white; }
    .status-Cancelled { background-color: #dc3545; color: white; }
    .btn-create { background-color: #007bff; border-color: #007bff; }
</style>

<div class="appointment-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="card-title"><i class="fas fa-user-shield me-2"></i> Administrator: All Appointments</h1>
        <button class="btn btn-create py-2 px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">
            <i class="fas fa-plus me-1"></i> Schedule New Appointment
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Appointments Table --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            @if($appointments->isEmpty())
                <div class="alert alert-info m-4">No appointments currently scheduled.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date & Time</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>#{{ $appointment->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }}</td>
                                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                    <td>Dr. {{ $appointment->doctor->name ?? 'N/A' }}</td>
                                    <td><span class="status-badge status-{{ $appointment->status }}">{{ $appointment->status }}</span></td>
                                    <td>
                                        <button class="btn btn-sm text-primary action-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editAppointmentModal"
                                                data-id="{{ $appointment->id }}"
                                                data-patient-id="{{ $appointment->patient_id }}"
                                                data-doctor-id="{{ $appointment->doctor_id }}"
                                                data-date-time="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
                                                data-status="{{ $appointment->status }}"
                                                data-notes="{{ $appointment->notes }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger action-btn" onclick="return confirm('Confirm permanent deletion?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
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

{{-- MODAL 1: CREATE APPOINTMENT (Admin) --}}
@include('includes.admin.create-modal', ['patients' => $patients, 'doctors' => $doctors])

{{-- MODAL 2: EDIT APPOINTMENT (Admin) --}}
@include('includes.admin.edit-modal', ['patients' => $patients, 'doctors' => $doctors])

<script>
    // JavaScript for populating the Edit Modal fields (Admin)
    document.addEventListener('DOMContentLoaded', function () {
        var editAppointmentModal = document.getElementById('editAppointmentModal');
        editAppointmentModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var id = button.getAttribute('data-id');
            var form = document.getElementById('editAppointmentForm');
            
            // Set form action for PUT request
            form.setAttribute('action', '/admin/appointments/' + id);

            // Populate fields
            document.getElementById('edit_patient_id').value = button.getAttribute('data-patient-id');
            document.getElementById('edit_doctor_id').value = button.getAttribute('data-doctor-id');
            document.getElementById('edit_appointment_date').value = button.getAttribute('data-date-time');
            document.getElementById('edit_status').value = button.getAttribute('data-status');
            document.getElementById('edit_notes').value = button.getAttribute('data-notes');
        });
    });
</script>
@endsection --}}
