@extends('admin.home')

@section('content')
<div class="card shadow-sm p-4">
    <h2 class="mb-4">Book an Appointment</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="appointmentForm" action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

        {{-- Patient --}}
        <div class="mb-3">
            <label for="patient_id" class="form-label">Select Patient</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                <option value="">-- Choose a Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Doctor --}}
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Select Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                <option value="">-- Select Doctor --</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Appointment Date --}}
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" 
                   value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Available Day --}}
        <div class="mb-3">
            <label for="available_day" class="form-label">Available Day</label>
            <select name="available_day" id="available_day" class="form-select" required>
                <option value="">-- Select a day --</option>
            </select>
        </div>

        {{-- Time Slot --}}
        <div class="mb-3">
            <label for="time_slot" class="form-label">Available Time Slot</label>
            <select name="time_slot" id="time_slot" class="form-select" required>
                <option value="">-- Select a time slot --</option>
            </select>
        </div>

        {{-- Notes --}}
        <div class="mb-3">
            <label for="notes" class="form-label">Notes (optional)</label>
            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
        </div>

        {{-- Hidden fields for start_time and end_time --}}
        <input type="hidden" name="start_time" id="start_time" value="{{ old('start_time') }}">
        <input type="hidden" name="end_time" id="end_time" value="{{ old('end_time') }}">

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Book Appointment</button>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const daySelect = document.getElementById('available_day');
    const timeSelect = document.getElementById('time_slot');
    const startInput = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');

    // Fetch schedules when doctor is selected
    doctorSelect.addEventListener('change', async function() {
        const doctorId = this.value;
        
        // Reset all fields
        daySelect.innerHTML = '<option value="">-- Select a day --</option>';
        timeSelect.innerHTML = '<option value="">-- Select a time slot --</option>';
        startInput.value = '';
        endInput.value = '';

        if (!doctorId) return;

        try {
            const response = await fetch(`/admin/appointments/schedules/${doctorId}`);
            if (!response.ok) throw new Error('Failed to fetch schedule');
            const data = await response.json();

            // Populate days
            daySelect.innerHTML = '<option value="">-- Select a day --</option>';
            data.schedules.forEach(schedule => {
                const option = document.createElement('option');
                option.value = schedule.available_day;
                option.textContent = schedule.available_day;
                option.setAttribute('data-start', schedule.start_time);
                option.setAttribute('data-end', schedule.end_time);
                daySelect.appendChild(option);
            });

        } catch (error) {
            console.error('Error:', error);
            daySelect.innerHTML = '<option value="">Error loading schedule</option>';
        }
    });

    // Handle day selection
    daySelect.addEventListener('change', function() {
        const selectedDay = this.value;
        const selectedOption = this.options[this.selectedIndex];
        
        timeSelect.innerHTML = '<option value="">-- Select a time slot --</option>';
        startInput.value = '';
        endInput.value = '';

        if (selectedDay && selectedOption) {
            const startTime = selectedOption.getAttribute('data-start');
            const endTime = selectedOption.getAttribute('data-end');
            
            if (startTime && endTime) {
                const timeSlot = `${startTime} - ${endTime}`;
                
                // Create time slot option
                const option = document.createElement('option');
                option.value = timeSlot;
                option.textContent = timeSlot;
                timeSelect.appendChild(option);
                
                // Set hidden values
                startInput.value = startTime;
                endInput.value = endTime;
            }
        }
    });

    // Form validation before submit
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        const patientId = document.getElementById('patient_id').value;
        const doctorId = document.getElementById('doctor_id').value;
        const appointmentDate = document.getElementById('appointment_date').value;
        const availableDay = document.getElementById('available_day').value;
        const timeSlot = document.getElementById('time_slot').value;
        
        if (!patientId || !doctorId || !appointmentDate || !availableDay || !timeSlot) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
        
        return true;
    });
});
</script>
@endsection