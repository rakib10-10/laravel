@extends('admin.home')

@section('content')
<div class="container mt-4">
    <h2>Book Appointment</h2>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        {{-- Patient (hidden if logged in as patient, or selectable if admin) --}}
        <input type="hidden" name="patient_id" value="{{ auth()->user()->patient->id ?? '' }}">

        {{-- Doctor Select --}}
        <div class="form-group mb-3">
            <label for="doctor_id">Select Doctor:</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                <option value="">-- Select Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Appointment Date --}}
        <div class="form-group mb-3">
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
        </div>

        {{-- Available Time Slots (loaded dynamically) --}}
        <div class="form-group mb-3">
            <label for="schedule_id">Available Time:</label>
            <select name="schedule_id" id="time_slot" class="form-select" required>
                <option value="">-- Select Time --</option>
            </select>
        </div>

        {{-- Notes --}}
        <div class="form-group mb-3">
            <label for="notes">Notes:</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div>
@endsection

{{-- Scripts --}}
@section('scripts')
<script>
document.getElementById('doctor_id').addEventListener('change', function() {
    let doctorId = this.value;
    let timeSlotSelect = document.getElementById('time_slot');
    timeSlotSelect.innerHTML = '<option>Loading...</option>';

    if (!doctorId) {
        timeSlotSelect.innerHTML = '<option value="">-- Select Time --</option>';
        return;
    }

    fetch(`/admin/appointments/schedules/${doctorId}`)
        .then(res => res.json())
        .then(data => {
            timeSlotSelect.innerHTML = '<option value="">-- Select Time --</option>';
            data.schedules.forEach(schedule => {
                let option = document.createElement('option');
                option.value = schedule.id;
                option.textContent = `${schedule.available_day} (${schedule.start_time} - ${schedule.end_time})`;
                timeSlotSelect.appendChild(option);
            });
        })
        .catch(err => {
            timeSlotSelect.innerHTML = '<option>Error loading times</option>';
            console.error(err);
        });
});
</script>
@endsection
