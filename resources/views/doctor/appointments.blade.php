@extends('layouts.doctor_home')

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
</style>

<div class="appointment-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="card-title"><i class="fas fa-stethoscope me-2"></i> Doctor: My Appointments</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Appointments Table --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            @if($appointments->isEmpty())
                <div class="alert alert-info m-4">No appointments are currently assigned to you.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Patient</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y h:i A') }}</td>
                                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($appointment->notes, 40, '...') }}</td>
                                    <td><span class="status-badge status-{{ $appointment->status }}">{{ $appointment->status }}</span></td>
                                    <td>
                                        <button class="btn btn-sm text-primary action-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateStatusModal"
                                                data-id="{{ $appointment->id }}"
                                                data-patient-name="{{ $appointment->patient->name ?? 'N/A' }}"
                                                data-date-time="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y h:i A') }}"
                                                data-status="{{ $appointment->status }}"
                                                data-notes="{{ $appointment->notes }}">
                                            <i class="fas fa-sync-alt"></i> Update Status
                                        </button>
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

{{-- MODAL: UPDATE STATUS (Doctor) --}}
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateStatusModalLabel"><i class="fas fa-edit me-2"></i> Update Appointment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="updateStatusForm">
                @csrf
                @method('PUT') 
                <div class="modal-body">
                    <p class="mb-3">Patient: <strong id="modal_patient_name"></strong></p>
                    <p class="mb-4">Time: <strong id="modal_date_time"></strong></p>
                    
                    <div class="mb-3">
                        <label for="update_status" class="form-label fw-bold">Change Status</label>
                        <select id="update_status" name="status" class="form-select">
                            <option value="Scheduled">Scheduled</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="update_notes" class="form-label fw-bold">Notes</label>
                        <textarea class="form-control" name="notes" id="update_notes" rows="3" placeholder="Add diagnosis, next steps, or cancellation reason."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary rounded-pill"><i class="fas fa-check me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript for populating the Update Status Modal fields (Doctor)
    document.addEventListener('DOMContentLoaded', function () {
        var updateStatusModal = document.getElementById('updateStatusModal');
        updateStatusModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var id = button.getAttribute('data-id');
            var form = document.getElementById('updateStatusForm');
            
            // Set form action for PUT request (Doctor route)
            form.setAttribute('action', '/doctor/appointments/' + id);

            // Populate display fields
            document.getElementById('modal_patient_name').textContent = button.getAttribute('data-patient-name');
            document.getElementById('modal_date_time').textContent = button.getAttribute('data-date-time');

            // Populate input fields
            document.getElementById('update_status').value = button.getAttribute('data-status');
            document.getElementById('update_notes').value = button.getAttribute('data-notes');
        });
    });
</script>
@endsection
