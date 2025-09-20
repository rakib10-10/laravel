@extends('admin.home')

@section('appointment')
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

        <div class="form-group">
            <label for="appointment_date">Choose Date:</label>
            <input type="date" name="appointment_date" id="appointment_date" required />
        </div>

        {{-- Dynamic fields for schedule and time will be added here via JavaScript --}}
        <div id="schedule-container" style="display: none;">
            <div class="form-group">
                <label for="available_day">Available Day:</label>
                <select id="available_day" required>
                    {{-- Options populated by JS --}}
                </select>
            </div>
            <div class="form-group">
                <label for="time_slot">Available Time:</label>
                <select id="time_slot" required>
                    {{-- Options populated by JS --}}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea name="notes" id="notes" rows="4" placeholder="Describe your issue..."></textarea>
        </div>

        <button type="submit">Book Appointment</button>
    </form>
</div>

<script>
    document.getElementById('doctor').addEventListener('change', function() {
        const doctorId = this.value;
        const scheduleContainer = document.getElementById('schedule-container');
        const daySelect = document.getElementById('available_day');
        const timeSelect = document.getElementById('time_slot');

        // Clear previous options
        daySelect.innerHTML = '';
        timeSelect.innerHTML = '';
        scheduleContainer.style.display = 'none';

        if (doctorId) {
            // Fetch schedules via AJAX
            fetch(`/admin/appointments/schedules/${doctorId}`)
                .then(response => response.json())
                .then(schedules => {
                    if (schedules.length > 0) {
                        scheduleContainer.style.display = 'block';
                        const uniqueDays = [...new Set(schedules.map(s => s.available_day))];
                        
                        uniqueDays.forEach(day => {
                            const option = document.createElement('option');
                            option.value = day;
                            option.textContent = day;
                            daySelect.appendChild(option);
                        });

                        // Set up event listener for the day select
                        daySelect.addEventListener('change', function() {
                            const selectedDay = this.value;
                            timeSelect.innerHTML = ''; // Clear times
                            const daySchedules = schedules.filter(s => s.available_day === selectedDay);
                            
                            daySchedules.forEach(slot => {
                                const option = document.createElement('option');
                                option.value = `${slot.start_time}-${slot.end_time}`;
                                option.textContent = `${slot.start_time} - ${slot.end_time}`;
                                timeSelect.appendChild(option);
                            });
                        });

                        // Trigger change to load initial times
                        daySelect.dispatchEvent(new Event('change'));
                    }
                })
                .catch(error => console.error('Error fetching schedules:', error));
        }
    });
</script>
@endsection