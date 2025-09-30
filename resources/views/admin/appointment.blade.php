@extends('admin.home')

@section('content')
<div class="appointment-container card shadow-sm p-4">
    <h1 class="mb-4">Book an Appointment</h1>

    <form class="appointment-form" action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

         {{-- Patient (hidden if logged in as patient, or selectable if admin) --}}
        <input type="hidden" name="patient_id" value="{{ auth()->user()->patient->id ?? '' }}">


        <!-- Doctor Selection -->
        <div class="form-group mb-3">
    <label for="doctor" class="form-label"><strong>Select Doctor:</strong></label>
    <select name="doctor_id" id="doctor" class="form-select" required>
        <option value="">-- Choose a Doctor --</option>
        @foreach($doctors as $doc)
            <option value="{{ $doc->id }}"
                    data-name="{{ $doc->name }}"
                    data-designation="{{ $doc->designation }}"
                    data-email="{{ $doc->email }}"
                    data-contact="{{ $doc->contact }}"
                    data-address="{{ $doc->address }}"
                    data-country="{{ $doc->country }}"
                    data-dob="{{ $doc->date_of_birth }}"
                    data-doj="{{ $doc->date_of_joining }}"
                    data-blood="{{ $doc->blood_group }}"
                    data-license="{{ $doc->license_number }}"
                    data-specialization="{{ $doc->specialization }}"
                    data-department="{{ $doc->department }}"
                    data-experience="{{ $doc->work_experience }}"
                    data-image="{{ $doc->profile_image ? asset('images/'.$doc->profile_image) : asset('images/default-doctor.png') }}">
                {{ $doc->name }}
            </option>
        @endforeach
    </select>
</div>

<!-- Doctor Details Preview -->
<div id="doctor-details" class="card p-3 mb-4" style="display:none;">
    <div class="row g-3">
        <div class="col-md-3 text-center">
            <img id="doctor-image" src="" 
                 class="rounded-circle border border-secondary mb-2" 
                 style="width:120px; height:120px; object-fit:cover;" />
            <h4 id="doctor-name" class="mt-2"></h4>
            <p id="doctor-designation" class="text-muted"></p>
        </div>
        <div class="col-md-9">
            <div class="row mb-2">
                <div class="col-md-6"><strong>Email:</strong> <span id="doctor-email"></span></div>
                <div class="col-md-6"><strong>Contact:</strong> <span id="doctor-contact"></span></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Address:</strong> <span id="doctor-address"></span></div>
                <div class="col-md-6"><strong>Country:</strong> <span id="doctor-country"></span></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Date of Birth:</strong> <span id="doctor-dob"></span></div>
                <div class="col-md-6"><strong>Date of Joining:</strong> <span id="doctor-doj"></span></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Blood Group:</strong> <span id="doctor-blood"></span></div>
                <div class="col-md-6"><strong>License Number:</strong> <span id="doctor-license"></span></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Specialization:</strong> <span id="doctor-specialization"></span></div>
                <div class="col-md-6"><strong>Department:</strong> <span id="doctor-department"></span></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Work Experience:</strong> <span id="doctor-experience"></span> years</div>
            </div>
        </div>
    </div>
</div>

        <!-- Appointment Date -->
       <!-- Schedule Section -->
<div id="schedule-container" style="display:none;">
    <div class="form-group mb-3">
        <label for="available_day" class="form-label"><strong>Available Day:</strong></label>
        <select name="available_day" id="available_day" class="form-select" required>
            <option value="">-- Select Day --</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="time_slot" class="form-label"><strong>Available Time:</strong></label>
        <select name="time_slot" id="time_slot" class="form-select" required>
            <option value="">-- Select Time --</option>
        </select>
    </div>
</div>


        <!-- Notes -->
        <div class="form-group mb-3">
            <label for="notes" class="form-label"><strong>Notes:</strong></label>
            <textarea name="notes" id="notes" rows="4" class="form-control" placeholder="Describe your issue..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
    </form>
</div>

<script>
document.getElementById('doctor').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const detailsDiv = document.getElementById('doctor-details');
    const doctorId = this.value;

    // Doctor details elements
    const fields = {
        name: 'doctor-name',
        designation: 'doctor-designation',
        email: 'doctor-email',
        contact: 'doctor-contact',
        address: 'doctor-address',
        country: 'doctor-country',
        dob: 'doctor-dob',
        doj: 'doctor-doj',
        blood: 'doctor-blood',
        license: 'doctor-license',
        specialization: 'doctor-specialization',
        department: 'doctor-department',
        experience: 'doctor-experience',
        image: 'doctor-image'
    };

    // Reset doctor details if no doctor selected
    if (!doctorId) {
        detailsDiv.style.display = 'none';
    } else {
        // Fill doctor preview from <option data-* attributes>
        document.getElementById(fields.name).textContent = selected.dataset.name || 'N/A';
        document.getElementById(fields.designation).textContent = selected.dataset.designation || '';
        document.getElementById(fields.email).textContent = selected.dataset.email || 'N/A';
        document.getElementById(fields.contact).textContent = selected.dataset.contact || 'N/A';
        document.getElementById(fields.address).textContent = selected.dataset.address || 'N/A';
        document.getElementById(fields.country).textContent = selected.dataset.country || 'N/A';
        document.getElementById(fields.dob).textContent = selected.dataset.dob || 'N/A';
        document.getElementById(fields.doj).textContent = selected.dataset.doj || 'N/A';
        document.getElementById(fields.blood).textContent = selected.dataset.blood || 'N/A';
        document.getElementById(fields.license).textContent = selected.dataset.license || 'N/A';
        document.getElementById(fields.specialization).textContent = selected.dataset.specialization || 'N/A';
        document.getElementById(fields.department).textContent = selected.dataset.department || 'N/A';
        document.getElementById(fields.experience).textContent = selected.dataset.experience || '0';
        document.getElementById(fields.image).src = selected.dataset.image;

        detailsDiv.style.display = 'block';
    }

    // Schedule container and selects
    const scheduleContainer = document.getElementById('schedule-container');
    const daySelect = document.getElementById('available_day');
    const timeSelect = document.getElementById('time_slot');

    // Reset UI
    daySelect.innerHTML = '<option value="">-- Select Day --</option>';
    timeSelect.innerHTML = '<option value="">-- Select Time --</option>';
    scheduleContainer.style.display = 'none';

    if (!doctorId) return;

    // Fetch schedules from backend
    fetch(`/admin/appointments/schedules/${doctorId}`)
        .then(response => response.json())
        .then(data => {
            const schedules = Array.isArray(data.schedules) ? data.schedules : [];

            if (schedules.length === 0) {
                daySelect.innerHTML = '<option value="">No available days</option>';
                return;
            }

            // Get unique available days
            const uniqueDays = [...new Set(schedules.map(s => s.available_day))];

            uniqueDays.forEach(day => {
                const option = document.createElement('option');
                option.value = day;
                option.textContent = day;
                daySelect.appendChild(option);
            });

            scheduleContainer.style.display = 'block';

            // Load times for selected day
            daySelect.onchange = function () {
                const selectedDay = this.value;
                timeSelect.innerHTML = '<option value="">-- Select Time --</option>';

                const daySchedules = schedules.filter(s => s.available_day === selectedDay);

                if (daySchedules.length === 0) {
                    timeSelect.innerHTML = '<option value="">No time slots</option>';
                } else {
                    daySchedules.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = `${slot.start_time}-${slot.end_time}`;
                        option.textContent = `${slot.start_time} - ${slot.end_time}`;
                        timeSelect.appendChild(option);
                    });
                }
            };
        })
        .catch(error => {
            console.error('Error fetching schedules:', error);
            alert('Unable to load doctor schedules.');
        });
});

</script>


<style>
    .appointment-container {
        max-width: 800px;
        margin: 30px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    .form-label {
        font-weight: 600;
    }
    button {
        border-radius: 8px;
        padding: 10px;
        font-size: 16px;
    }
</style>
@endsection
