@extends('layouts.patient_home') 

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title text-primary mb-4 pb-2 border-bottom">Book New Appointment</h1>
                    <p class="text-muted mb-4">Please select a doctor, an available date, and a time slot to proceed with your booking request.</p>

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Booking Error!</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('patient.appointments.store') }}" method="POST" id="appointment-form">
                        @csrf

                        {{-- Hidden Inputs --}}
                        <input type="hidden" name="appointment_date" id="input-date" value="{{ old('appointment_date') }}">
                        <input type="hidden" name="time_slot" id="input-slot" value="{{ old('time_slot') }}">

                        {{-- Doctor Selection --}}
                        <div class="mb-4">
                            <label for="doctor_id" class="form-label fw-semibold">Select Doctor</label>
                            <select id="doctor_id" name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror">
                                <option value="">-- Choose a Doctor --</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->name }} ({{ $doctor->specialty ?? 'General Practitioner' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Date Selection --}}
                        <div class="mb-4">
                            <label for="scheduled_date" class="form-label fw-semibold">Select Date (Up to 7 days ahead)</label>
                            <input type="date" id="scheduled_date" name="scheduled_date_display"
                                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   max="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}"
                                   value="{{ old('scheduled_date_display') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   class="form-control @error('appointment_date') is-invalid @enderror">
                        </div>

                        {{-- Available Slots --}}
                        <div id="slots-container" class="slot-container">
                            <h3 class="h5 text-secondary mb-3">Available Time Slots</h3>
                            <div id="loading-indicator" class="text-center text-primary py-3 d-none">
                                <div class="spinner-border spinner-border-sm me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Loading schedules...
                            </div>
                            <div id="slots-message" class="alert alert-info text-center" role="alert">
                                Please select a doctor and a date to see available time slots.
                            </div>
                            <div id="slots-list" class="row g-2"></div>
                        </div>

                        {{-- Reason --}}
                        <div class="mt-4">
                            <label for="reason" class="form-label fw-semibold">Reason for Appointment (Optional)</label>
                            <textarea id="reason" name="reason" rows="3" class="form-control" placeholder="Briefly describe the reason for your visit.">{{ old('reason') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <button type="submit" id="submit-button" class="btn btn-primary btn-lg px-5 shadow-sm" 
                                    {{ (old('appointment_date') && old('time_slot')) ? '' : 'disabled' }}>
                                Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
.slot-button {
    transition: all 0.2s;
    cursor: pointer;
    border: 1px solid #0d6efd;
    background-color: #f0f8ff;
    color: #0d6efd;
}
.slot-button.selected {
    background-color: #0d6efd !important;
    color: white !important;
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.5) !important;
}
.slot-button:hover:not(.selected) {
    background-color: #cfe2ff;
}
.slot-container {
    border-top: 1px solid #dee2e6;
    padding-top: 1.5rem;
    margin-top: 1rem;
}
</style>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('scheduled_date');
    const slotsList = document.getElementById('slots-list');
    const slotsMessage = document.getElementById('slots-message');
    const loadingIndicator = document.getElementById('loading-indicator');
    const inputDate = document.getElementById('input-date');
    const inputSlot = document.getElementById('input-slot');
    const submitButton = document.getElementById('submit-button');

    let selectedSlotElement = null;

    function clearSlotSelection() {
        if (selectedSlotElement) selectedSlotElement.classList.remove('selected');
        selectedSlotElement = null;
        inputSlot.value = '';
        submitButton.disabled = true;
    }

    function handleSlotSelection(element, date, slot) {
        clearSlotSelection();
        element.classList.add('selected');
        selectedSlotElement = element;
        inputDate.value = date;
        inputSlot.value = slot;
        submitButton.disabled = false;
    }

    function renderSlots(schedules, selectedDate) {
        slotsList.innerHTML = '';
        clearSlotSelection();

        const daySchedule = schedules.find(s => s.available_day === selectedDate);

        if (!daySchedule || daySchedule.slots.length === 0) {
            slotsMessage.textContent = `No available slots for ${selectedDate}. Choose another date or doctor.`;
            slotsMessage.classList.remove('d-none', 'alert-info');
            slotsMessage.classList.add('alert-warning');
            return;
        }

        slotsMessage.classList.add('d-none');

        daySchedule.slots.forEach(slot => {
            const [startTime] = slot.split('-');
            const col = document.createElement('div');
            col.className = 'col-4 col-sm-3 col-md-2';

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'slot-button btn btn-outline-primary w-100 btn-sm';
            button.textContent = startTime;

            if (inputSlot.value === slot && inputDate.value === selectedDate) {
                button.classList.add('selected');
                selectedSlotElement = button;
                submitButton.disabled = false;
            }

            button.addEventListener('click', () => handleSlotSelection(button, selectedDate, slot));

            col.appendChild(button);
            slotsList.appendChild(col);
        });
    }

    async function fetchSchedules() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;

        clearSlotSelection();
        slotsList.innerHTML = '';
        slotsMessage.classList.add('d-none');

        if (!doctorId || !date) {
            slotsMessage.textContent = 'Please select both a doctor and a date.';
            slotsMessage.classList.remove('d-none', 'alert-danger');
            slotsMessage.classList.add('alert-info');
            return;
        }

        loadingIndicator.classList.remove('d-none');

        try {
            // FIXED URL: matches your web.php route
            const response = await fetch(`/patient/doctors/${doctorId}/schedules?date=${date}`);
            if (!response.ok) throw new Error(`Server returned ${response.status}`);
            const data = await response.json();

            if (!data.schedules || !Array.isArray(data.schedules)) throw new Error('Invalid data format');

            renderSlots(data.schedules, date);

        } catch (error) {
            console.error(error);
            slotsMessage.textContent = 'Error loading schedules. Check console for details.';
            slotsMessage.classList.remove('d-none', 'alert-info', 'alert-warning');
            slotsMessage.classList.add('alert-danger');
        } finally {
            loadingIndicator.classList.add('d-none');
        }
    }

    doctorSelect.addEventListener('change', fetchSchedules);
    dateInput.addEventListener('change', fetchSchedules);

    if (doctorSelect.value && dateInput.value) {
        inputDate.value = dateInput.value;
        fetchSchedules();
    }
});

</script>

@endsection
