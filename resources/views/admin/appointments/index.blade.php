@extends('admin.home')

@section('content')
<style>
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
    .appointment-container { padding: 40px 20px; max-width: 1400px; margin: auto; }
    .card-title { font-weight: 700; color: #343a40; }
    .table th { background-color: #343a40; color: white; border: none; font-size: 0.9rem; }
    .table td { font-size: 0.85rem; vertical-align: middle; }
    .status-badge { padding: 5px 12px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; }
    .status-pending { background-color: #ffc107; color: black; }
    .status-confirmed { background-color: #17a2b8; color: white; }
    .status-completed { background-color: #28a745; color: white; }
    .status-cancelled { background-color: #dc3545; color: white; }
    .btn-create { background-color: #007bff; border-color: #007bff; }
    
    /* Improved table responsiveness */
    .table-responsive { 
        border-radius: 0.375rem;
        overflow: hidden;
    }
    
    /* Better button spacing */
    .btn-group-sm > .btn,
    .btn-group-sm > form {
        margin: 0 2px;
    }
    
    /* Ensure text truncation works */
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Dropdown improvements */
    .dropdown-menu {
        min-width: 120px;
    }
    
    .dropdown-item {
        font-size: 0.8rem;
        padding: 0.25rem 0.75rem;
    }
</style>

<div class="appointment-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="card-title"><i class="fas fa-user-shield me-2"></i> Administrator: All Appointments</h1>
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-create py-2 px-3 fw-bold">
            <i class="fas fa-plus me-1"></i> Schedule New Appointment
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

  {{-- Appointments Table --}}
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0" >
        @if($appointments->isEmpty())
            <div class="alert alert-info m-4">No appointments currently scheduled.</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 10%;">Date</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 15%;">Patient</th>
                            <th style="width: 15%;">Doctor</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td class="text-nowrap">#{{ $appointment->id }}</td>
                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - 
                                            {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                        </span>
                                        @if($appointment->time_slot)
                                            <small class="text-muted text-nowrap">Slot: {{ $appointment->time_slot }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 120px;" title="{{ $appointment->patient->name ?? 'N/A' }}">
                                        {{ $appointment->patient->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 120px;" title="Dr. {{ $appointment->doctor->name ?? 'N/A' }}">
                                        Dr. {{ $appointment->doctor->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn status-badge status-{{ $appointment->status }} dropdown-toggle py-1 px-2" 
                                                type="button" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false"
                                                style="border: none; font-size: 0.75rem; width: 100px;">
                                            {{ ucfirst($appointment->status) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item status-option" href="#" data-status="pending" data-appointment-id="{{ $appointment->id }}">Pending</a></li>
                                            <li><a class="dropdown-item status-option" href="#" data-status="confirmed" data-appointment-id="{{ $appointment->id }}">Confirmed</a></li>
                                            <li><a class="dropdown-item status-option" href="#" data-status="completed" data-appointment-id="{{ $appointment->id }}">Completed</a></li>
                                            <li><a class="dropdown-item status-option" href="#" data-status="cancelled" data-appointment-id="{{ $appointment->id }}">Cancelled</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.appointments.show', $appointment->id) }}" 
                                           class="btn btn-info text-white" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.appointments.edit', $appointment->id) }}" 
                                           class="btn btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger" 
                                                    onclick="return confirm('Confirm permanent deletion?')"
                                                    title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

    {{-- Display pagination links --}}
    @if($appointments->hasPages())
    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status update functionality
    const statusOptions = document.querySelectorAll('.status-option');
    
    statusOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            const appointmentId = this.dataset.appointmentId;
            const newStatus = this.dataset.status;
            
            // Update via AJAX
            updateAppointmentStatus(appointmentId, newStatus);
        });
    });
    
    function updateAppointmentStatus(appointmentId, status) {
        fetch(`/admin/appointments/${appointmentId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the button text and classes
                const button = document.querySelector(`[data-appointment-id="${appointmentId}"]`).closest('.dropdown').querySelector('.dropdown-toggle');
                button.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                button.className = `btn status-badge status-${data.status} dropdown-toggle py-1 px-3`;
                
                // Show success message
                showToast('Status updated successfully!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error updating status!', 'error');
        });
    }
    
    function showToast(message, type = 'info') {
        // Simple toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('.appointment-container').prepend(toast);
    }
});
</script>

@endsection