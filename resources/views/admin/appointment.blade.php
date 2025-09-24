@extends('admin.home')

@section('content')
<style>
    /* Elegant and Modern Design */
    .appointment-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', sans-serif;
    }

    .appointment-container h1 {
        font-size: 2.2rem;
        color: #1d3557;
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #a8dadc;
        padding-bottom: 10px;
    }

    .appointment-form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #457b9d;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #a8dadc;
        box-shadow: 0 0 0 3px rgba(168, 218, 220, 0.3);
        outline: none;
    }

    .appointment-form button {
        background: #457b9d;
        color: white;
        padding: 15px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 15px;
    }

    .appointment-form button:hover {
        background: #1d3557;
        transform: translateY(-2px);
    }
</style>

<div class="appointment-container">
    <h1>Book an Appointment</h1>

    <form class="appointment-form" action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="doctor">Select Doctor:</label>
            <select name="doctor_id" id="doctor" required>
                <option value="">-- Choose a Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Doctor details populated by JS (NO server-side $doctor variable here) -->
        <div id="doctor-details" style="display:none; margin-top: 20px; padding: 16px; background: #f8f9fa; border-radius: 10px; border: 1px solid #ddd; align-items:flex-start; gap:16px;">
            <div style="display:flex; gap:16px; align-items:flex-start;">
                <img id="doctor-image" src="{{ asset('images/default-doctor.png') }}" alt="Doctor Image"
                     style="width:100px; height:100px; object-fit:cover; border-radius:50%; border:2px solid #ddd;">
                <div>
                    <h3 id="doctor-name" style="color: #1d3557; margin:0;"></h3>
                    <p style="margin:6px 0;"><strong>Specialization:</strong> <span id="doctor-specialization"></span></p>
                    <p style="margin:6px 0;"><strong>Email:</strong> <span id="doctor-email"></span></p>
                    <p style="margin:6px 0;"><strong>Contact:</strong> <span id="doctor-contact"></span></p>
                    <p id="doctor-bio" style="margin-top:8px; color:#555;"></p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="appointment_date">Choose Date:</label>
            <input type="date" name="appointment_date" id="appointment_date" required />
        </div>

        <!-- Dynamic schedule picks (these WILL be submitted because they have name attributes) -->
        {{-- Doctor Schedule Section --}}
<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h4>Doctor's Schedule</h4>
    </div>
    <div class="card-body">
        @if($doctor->schedules->isEmpty())
            <div class="alert alert-info" role="alert">
                No schedules found for this doctor.
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Available Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctor->schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->available_day }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
    
        <div id="schedule-container" style="display:none;">
            <div class="form-group">
                <label for="available_day">Available Day:</label>
                <select name="available_day" id="available_day" required>
                    <!-- Options populated by JS -->
                </select>
            </div>

           

        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea name="notes" id="notes" rows="4" placeholder="Describe your issue..."></textarea>
        </div>

        <button type="submit">Book Appointment</button>
    </form>
</div>

<script>
    // placeholder image path (Blade helper used to generate a correct URL)
    const placeholderImage = "{{ asset('images/default-doctor.png') }}";

    document.getElementById('doctor').addEventListener('change', function () {
        const doctorId = this.value;
        const scheduleContainer = document.getElementById('schedule-container');
        const daySelect = document.getElementById('available_day');
        const timeSelect = document.getElementById('time_slot');
        const doctorDetails = document.getElementById('doctor-details');

        // reset UI
        daySelect.innerHTML = '';
        timeSelect.innerHTML = '';
        scheduleContainer.style.display = 'none';
        doctorDetails.style.display = 'none';

        if (!doctorId) return;

        fetch(`/admin/appointments/schedules/${doctorId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const doctor = data.doctor || {};
                const schedules = Array.isArray(data.schedules) ? data.schedules : [];

                // Fill doctor preview
                document.getElementById('doctor-name').textContent = doctor.name || 'N/A';
                document.getElementById('doctor-specialization').textContent = doctor.specialization || 'N/A';
                document.getElementById('doctor-email').textContent = doctor.email || 'N/A';
                // use contact (your DB uses 'contact' field)
                document.getElementById('doctor-contact').textContent = doctor.contact || 'N/A';
                document.getElementById('doctor-bio').textContent = doctor.bio || '';
                const imgEl = document.getElementById('doctor-image');
                imgEl.src = doctor.profile_image ? `/images/${doctor.profile_image}` : placeholderImage;

                doctorDetails.style.display = 'block';

                // Populate schedules
                if (schedules.length > 0) {
                    scheduleContainer.style.display = 'block';

                    // unique days and a mapping for nicer display if you store abbreviations
                    const uniqueDays = [...new Set(schedules.map(s => s.available_day))];
                    const dayNames = {
                        'Mon':'Monday','Tue':'Tuesday','Wed':'Wednesday','Thu':'Thursday','Fri':'Friday','Sat':'Saturday','Sun':'Sunday',
                        'Monday':'Monday','Tuesday':'Tuesday','Wednesday':'Wednesday','Thursday':'Thursday','Friday':'Friday','Saturday':'Saturday','Sunday':'Sunday'
                    };

                    // add placeholder
                    const placeholder = document.createElement('option');
                    placeholder.value = '';
                    placeholder.textContent = '-- Select Day --';
                    daySelect.appendChild(placeholder);

                    uniqueDays.forEach(day => {
                        const option = document.createElement('option');
                        option.value = day;
                        option.textContent = dayNames[day] || day;
                        daySelect.appendChild(option);
                    });

                    // replace listener safely (no duplicates)
                    daySelect.onchange = function () {
                        const selectedDay = this.value;
                        timeSelect.innerHTML = '';

                        if (!selectedDay) {
                            const opt = document.createElement('option');
                            opt.value = '';
                            opt.textContent = '-- Select Time --';
                            timeSelect.appendChild(opt);
                            return;
                        }

                        const daySchedules = schedules.filter(s => s.available_day === selectedDay);

                        if (daySchedules.length === 0) {
                            const opt = document.createElement('option');
                            opt.value = '';
                            opt.textContent = 'No time slots';
                            timeSelect.appendChild(opt);
                        } else {
                            daySchedules.forEach(slot => {
                                const option = document.createElement('option');
                                option.value = `${slot.start_time}-${slot.end_time}`;
                                option.textContent = `${slot.start_time} - ${slot.end_time}`;
                                timeSelect.appendChild(option);
                            });
                        }
                    };

                    // auto pick first available day (if exists)
                    if (daySelect.options.length > 1) {
                        daySelect.selectedIndex = 1;
                        daySelect.dispatchEvent(new Event('change'));
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching schedules:', error);
                alert('Unable to load doctor details. Please try again.');
            });
    });
</script>
@endsection
