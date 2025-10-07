{{-- 
    NOTE: This file assumes Bootstrap 5 is loaded, and that the following variables 
    are passed from the controller: 
    - $doctors (Collection of Doctor models)
    - $patients (Collection of Patient models)
--}}
@extends('admin.home')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 mb-4 text-center text-primary border-bottom pb-3">
                        <i class="fas fa-calendar-check me-2"></i> Book New Appointment
                    </h1>

                    <form action="{{ route('admin.appointments.store') }}" method="POST">
                        @csrf

                        {{-- 1. Patient Selection (MANDATORY FOR ADMIN) --}}
                        <div class="mb-4">
                            <label for="patient_id" class="form-label fw-bold">Select Patient:</label>
                            <select id="patient_id" name="patient_id" required
                                class="form-select @error('patient_id') is-invalid @enderror">
                                <option value="" disabled selected>-- Choose a Patient --</option>
                                {{-- Assuming $patients is passed to the view --}}
                                @forelse($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} (ID: {{ $patient->id }})
                                    </option>
                                @empty
                                    <option value="" disabled>No patients available</option>
                                @endforelse
                            </select>
                            @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- 2. Doctor Selection --}}
                        <div class="mb-4">
                            <label for="doctor" class="form-label fw-bold">Select Doctor:</label>
                            <select name="doctor_id" id="doctor" required
                                class="form-select @error('doctor_id') is-invalid @enderror">
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
                                        {{ $doc->name }} ({{ $doc->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Doctor Details Preview --}}
                        <div id="doctor-details" class="card bg-light border-info mb-4" style="display:none;">
                            <div class="card-body">
                                <h4 class="card-title text-info mb-3">Doctor Profile</h4>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-3 text-center">
                                        <img id="doctor-image" src="" alt="Doctor Image"
                                            class="rounded-circle border border-info mb-2" 
                                            style="width:100px; height:100px; object-fit:cover;" />
                                        <h5 id="doctor-name" class="mt-2 text-dark fw-bold"></h5>
                                        <p id="doctor-designation" class="text-secondary small"></p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row g-2 small">
                                            <div class="col-sm-6"><strong>Email:</strong> <span id="doctor-email"></span></div>
                                            <div class="col-sm-6"><strong>Contact:</strong> <span id="doctor-contact"></span></div>
                                            <div class="col-sm-6"><strong>Specialization:</strong> <span id="doctor-specialization" class="fw-semibold text-primary"></span></div>
                                            <div class="col-sm-6"><strong>Department:</strong> <span id="doctor-department"></span></div>
                                            <div class="col-sm-6"><strong>Experience:</strong> <span id="doctor-experience"></span> years</div>
                                            <div class="col-sm-6"><strong>Blood Group:</strong> <span id="doctor-blood"></span></div>
                                            <div class="col-12"><strong>Address:</strong> <span id="doctor-address"></span>, <span id="doctor-country"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Schedule Section --}}
                        <div id="schedule-container" class="border p-4 rounded-3 bg-light mb-4" style="display:none;">
                            <h4 class="h6 fw-bold text-dark mb-3">Select Available Slot</h4>
                            
                            <div class="row g-4">
                                {{-- Available Day --}}
                                <div class="col-md-6">
                                    <label for="available_day" class="form-label fw-bold small">Available Day:</label>
                                    <select name="available_day" id="available_day" required
                                        class="form-select">
                                        <option value="">-- Select Day --</option>
                                    </select>
                                </div>

                                {{-- Available Time --}}
                                <div class="col-md-6">
                                    <label for="time_slot" class="form-label fw-bold small">Available Time:</label>
                                    {{-- Hidden fields to pass start_time and end_time separately for backend processing --}}
                                    <input type="hidden" name="start_time" id="start_time">
                                    <input type="hidden" name="end_time" id="end_time">
                                    
                                    <select name="time_slot_display" id="time_slot" required
                                        class="form-select">
                                        <option value="">-- Select Time --</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        {{-- 5. Notes --}}
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">Reason for Appointment (Notes):</label>
                            <textarea name="notes" id="notes" rows="4" 
                                class="form-control @error('notes') is-invalid @enderror" 
                                placeholder="Describe the reason for the appointment...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 6. Submit Button --}}
                        <div class="mt-4">
                            <button type="submit" 
                                    class="btn btn-primary btn-lg w-100 shadow-sm">
                                <i class="fas fa-plus-circle me-1"></i> Confirm and Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor');
    const daySelect = document.getElementById('available_day');
    const timeSelect = document.getElementById('time_slot');
    const scheduleContainer = document.getElementById('schedule-container');
    const doctorDetailsDiv = document.getElementById('doctor-details');
    
    // Function to handle the date/time slots population
    const updateTimeSlots = (schedules) => {
        // Load times when a day is selected
        daySelect.onchange = function () {
            const selectedDay = this.value;
            timeSelect.innerHTML = '<option value="">-- Select Time --</option>';
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';

            const daySchedules = schedules.filter(s => s.available_day === selectedDay);

            if (daySchedules.length === 0) {
                timeSelect.innerHTML = '<option value="" disabled>No time slots</option>';
            } else {
                daySchedules.forEach(slot => {
                    const option = document.createElement('option');
                    // Store start and end time in the value for easy extraction
                    option.value = `${slot.start_time}|${slot.end_time}`;
                    option.textContent = `${slot.start_time} - ${slot.end_time}`;
                    timeSelect.appendChild(option);
                });
            }
        };

        // Update hidden inputs when time is selected
        timeSelect.onchange = function() {
            const value = this.value;
            if (value && value.includes('|')) {
                const [start, end] = value.split('|');
                document.getElementById('start_time').value = start || '';
                document.getElementById('end_time').value = end || '';
            } else {
                document.getElementById('start_time').value = '';
                document.getElementById('end_time').value = '';
            }
        };
    };

    // Main change listener for Doctor selection
    doctorSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const doctorId = this.value;

        // Reset schedule UI
        daySelect.innerHTML = '<option value="">-- Select Day --</option>';
        timeSelect.innerHTML = '<option value="">-- Select Time --</option>';
        scheduleContainer.style.display = 'none';

        // Doctor details elements mapping
        const fields = {
            name: 'doctor-name', designation: 'doctor-designation', email: 'doctor-email',
            contact: 'doctor-contact', address: 'doctor-address', country: 'doctor-country',
            dob: 'doctor-dob', doj: 'doctor-doj', blood: 'doctor-blood', license: 'doctor-license',
            specialization: 'doctor-specialization', department: 'doctor-department',
            experience: 'doctor-experience', image: 'doctor-image'
        };

        if (!doctorId) {
            doctorDetailsDiv.style.display = 'none';
            return;
        }

        // Fill doctor preview from <option data-* attributes>
        document.getElementById(fields.name).textContent = selected.dataset.name || 'N/A';
        document.getElementById(fields.designation).textContent = selected.dataset.designation || '';
        document.getElementById(fields.email).textContent = selected.dataset.email || 'N/A';
        document.getElementById(fields.contact).textContent = selected.dataset.contact || 'N/A';
        document.getElementById(fields.address).textContent = selected.dataset.address || 'N/A';
        document.getElementById(fields.country).textContent = selected.dataset.country || 'N/A';
        // You may want to format these dates better in a real app
        // document.getElementById(fields.dob).textContent = selected.dataset.dob ? new Date(selected.dataset.dob).toLocaleDateString() : 'N/A'; 
        // document.getElementById(fields.doj).textContent = selected.dataset.doj ? new Date(selected.dataset.doj).toLocaleDateString() : 'N/A';
        document.getElementById(fields.blood).textContent = selected.dataset.blood || 'N/A';
        document.getElementById(fields.specialization).textContent = selected.dataset.specialization || 'N/A';
        document.getElementById(fields.department).textContent = selected.dataset.department || 'N/A';
        document.getElementById(fields.experience).textContent = selected.dataset.experience || '0';
        document.getElementById(fields.image).src = selected.dataset.image;
        doctorDetailsDiv.style.display = 'block';

        // Fetch schedules from backend
        // NOTE: This route '/admin/appointments/schedules/{doctorId}' must be defined in your Laravel routes file.
        fetch(`/admin/appointments/schedules/${doctorId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const schedules = Array.isArray(data.schedules) ? data.schedules : [];

                if (schedules.length === 0) {
                    daySelect.innerHTML = '<option value="" disabled>No available schedules found</option>';
                    return;
                }

                // Get unique available days
                const uniqueDays = [...new Set(schedules.map(s => s.available_day))];
                
                // Populate Day selection
                uniqueDays.forEach(day => {
                    const option = document.createElement('option');
                    option.value = day;
                    option.textContent = day;
                    daySelect.appendChild(option);
                });

                scheduleContainer.style.display = 'block';

                updateTimeSlots(schedules);

            })
            .catch(error => {
                console.error('Error fetching schedules:', error);
                // Use a Bootstrap modal or a simple alert (custom message box) instead of browser alert in a real application
                alert('An error occurred while loading doctor schedules. Please try again.'); 
            });
    });
});
</script>
@endsection
