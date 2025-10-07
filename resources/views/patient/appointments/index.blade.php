@extends('layouts.patient_home')

@section('content')

<div class="container py-4">
    <div class="mb-4">
        <h1 class="fw-bolder text-dark">My Appointments</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($appointments->isEmpty())
        <div class="card shadow-lg text-center p-5 border-0">
            <i class="fa-solid fa-calendar-times text-secondary fs-1 mb-3"></i>
            <p class="text-muted fs-5">You have no scheduled appointments. Start by booking one!</p>
        </div>
    @else
        <div class="card shadow-lg rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-3 text-uppercase text-muted" scope="col">Doctor</th>
                            <th class="px-3 py-3 text-uppercase text-muted" scope="col">Date</th>
                            <th class="px-3 py-3 text-uppercase text-muted" scope="col">Time Slot</th>
                            <th class="px-3 py-3 text-uppercase text-muted" scope="col">Status</th>
                            <th class="px-3 py-3 text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td class="px-3 py-3 fw-bold text-dark">
                                Dr. {{ $appointment->doctor->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-3 text-muted">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                            </td>
                            <td class="px-3 py-3">
                                @if (strtolower($appointment->status) == 'pending' && (empty($appointment->start_time) || empty($appointment->end_time)))
                                    <span class="text-primary fw-semibold">TBA - Awaiting Confirmation</span>
                                @else
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                @php
                                    $statusLower = strtolower($appointment->status);
                                    $statusClass = [
                                        'pending' => 'text-bg-warning',
                                        'confirmed' => 'text-bg-primary',
                                        'completed' => 'text-bg-success',
                                        'cancelled' => 'text-bg-danger',
                                    ][$statusLower] ?? 'text-bg-secondary';
                                @endphp
                                <span class="badge rounded-pill text-uppercase {{ $statusClass }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-end">
                                <div class="d-flex justify-content-end align-items-center">
                                    {{-- View Details Link --}}
                                    <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="btn btn-sm btn-outline-info me-2">
                                        Details
                                    </a>

                                    {{-- Cancel Form (only show if pending) --}}
                                    @if ($statusLower == 'pending')
                                        <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment request?');">
                                            @csrf
                                            @method('DELETE')
                                            {{-- NOTE: Switched to a custom UI element if possible, but kept confirm() for immediate use. --}}
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            {{-- The pagination section has been commented out as requested.
            <div class="card-footer bg-white border-0">
                {{ $appointments->links() }}
            </div>
            --}}
        </div>
    @endif

</div>
@endsection
