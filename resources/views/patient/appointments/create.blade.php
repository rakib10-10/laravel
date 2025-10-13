@extends('layouts.patient_home')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <section class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <header class="mb-4 pb-2 border-bottom">
                        <h1 class="text-primary">Book New Appointment</h1>
                        <p class="text-muted">Select a doctor, an available date, and a time slot to proceed.</p>
                    </header>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('patient.appointments.store') }}" method="POST" id="appointment-form" novalidate>
                        @csrf

                        {{-- Patient Name (FIX: Added form-control class) --}}
                        <div class="mb-4">
                            <label for="patient_name" class="form-label fw-semibold">Your Name</label>
                            <input type="text" name="patient_name" 
                                   value="{{ old('patient_name') ?? Auth::user()->name }}" 
                                   class="form-control" {{-- Added form-control class --}}
                                   required>
                        </div>

                        {{-- Doctor Selection --}}
                        <div class="mb-4">
                            <label for="doctor_id" class="form-label fw-semibold">Select Doctor</label>
                            <select id="doctor_id" name="doctor_id" class="form-select" required>
                                <option value="">-- Choose a Doctor --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->name }} ({{ $doctor->specialty ?? 'General' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date Selection --}}
                        <div class="mb-4">
                            <label for="scheduled_date" class="form-label fw-semibold">Select Date (next 7 days)</label>
                            <input type="date" id="scheduled_date" name="scheduled_date"
                                    min="{{ now()->format('Y-m-d') }}"
                                    max="{{ now()->addDays(7)->format('Y-m-d') }}"
                                    value="{{ old('scheduled_date') ?? now()->format('Y-m-d') }}"
                                    class="form-control" required>
                        </div>

                        {{-- Available Slots --}}
                        <div id="slots-container" class="slot-container mb-4">
                            <h2 class="h5 text-secondary mb-3">Available Time Slots</h2>
                            <div id="slots-message" class="alert alert-info text-center">
                                Please select a doctor and date to see available slots.
                            </div>
                            <div id="slots-list" class="row g-2"></div>
                        </div>

                        <input type="hidden" name="slot_id" id="input-slot">

                        {{-- Reason --}}
                        <div class="mb-4">
                            <label for="reason" class="form-label fw-semibold">Reason (Optional)</label>
                            <textarea id="reason" name="reason" rows="3" class="form-control">{{ old('reason') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <button type="submit" id="submit-button" class="btn btn-primary btn-lg px-5" disabled>
                                Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
.slot-button {
    cursor: pointer;
}
.slot-button.selected {
    background-color: #0d6efd;
    color: white;
}
/* Ensure booked slots don't look clickable */
.slot-button.disabled {
    cursor: not-allowed;
    pointer-events: none; /* Prevents click events from firing */
    opacity: 0.6;
}
.slot-container {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('scheduled_date');
    const slotsList = document.getElementById('slots-list');
    const slotsMessage = document.getElementById('slots-message');
    const inputSlot = document.getElementById('input-slot');
    const submitButton = document.getElementById('submit-button');

    let selectedSlot = null;

    function clearSelection() {
        if (selectedSlot) selectedSlot.classList.remove('selected');
        selectedSlot = null;
        inputSlot.value = '';
        submitButton.disabled = true;
    }

    function renderSlots(slots) {
        slotsList.innerHTML = '';
        clearSelection();

        if (!slots.length) {
            slotsMessage.textContent = `No slots found for ${dateInput.value}.`;
            slotsMessage.classList.remove('d-none', 'alert-info', 'alert-danger');
            slotsMessage.classList.add('alert-warning');
            return;
        }

        slotsMessage.classList.add('d-none');

        slots.forEach(slot => {
            const isBooked = slot.is_booked; // Use the status returned by the controller
            
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = slot.display;
            
            // Determine styling and interactivity based on is_booked status
            if (isBooked) {
                // Booked slots are red, disabled, and not clickable
                btn.className = 'slot-button btn btn-danger disabled col';
                btn.title = 'This slot is already booked';
            } else {
                // Available slots are blue outline and clickable
                btn.className = 'slot-button btn btn-outline-primary col';
                
                btn.addEventListener('click', () => {
                    clearSelection();
                    btn.classList.add('selected');
                    selectedSlot = btn;
                    inputSlot.value = slot.id;
                    submitButton.disabled = false;
                });
            }

            slotsList.appendChild(btn);
        });
    }

    async function fetchSlots() {
        clearSelection();
        slotsList.innerHTML = '';
        slotsMessage.classList.remove('alert-warning', 'alert-danger');

        if (!doctorSelect.value || !dateInput.value) {
            slotsMessage.textContent = 'Please select a doctor and date to see available slots.';
            slotsMessage.classList.remove('d-none');
            slotsMessage.classList.add('alert-info');
            return;
        }

        slotsMessage.textContent = 'Loading slots...';
        slotsMessage.classList.remove('d-none');
        slotsMessage.classList.add('alert-info');

        try {
            const res = await fetch(`/patient/doctors/${doctorSelect.value}/schedules?date=${dateInput.value}`);
            const data = await res.json();

            if (data.success) {
                renderSlots(data.slots);
            } else {
                slotsMessage.textContent = data.message || 'Error fetching slots.';
                slotsMessage.classList.remove('d-none', 'alert-info');
                slotsMessage.classList.add('alert-danger');
            }
        } catch (err) {
            console.error('Fetch error:', err);
            slotsMessage.textContent = 'A network error occurred while loading slots.';
            slotsMessage.classList.remove('d-none', 'alert-info');
            slotsMessage.classList.add('alert-danger');
        }
    }

    doctorSelect.addEventListener('change', fetchSlots);
    dateInput.addEventListener('change', fetchSlots);

    // Initial load if old input exists (e.g., after a validation error)
    if (doctorSelect.value && dateInput.value) {
        fetchSlots();
    }
});
</script>
@endsection
