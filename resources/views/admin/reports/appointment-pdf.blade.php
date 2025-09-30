<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Appointment Confirmation</h2>
    </div>

    <div class="info">
        <strong>Appointment ID:</strong> {{ $appointment->id }} <br>
        <strong>Status:</strong> {{ ucfirst($appointment->status) }} <br>
        <strong>Date:</strong> {{ $appointment->appointment_date }} <br>
    </div>

    <h3>Doctor Details</h3>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $doctor->name }}</td>
        </tr>
        <tr>
            <th>Specialization</th>
            <td>{{ $doctor->specialization ?? 'N/A' }}</td>
        </tr>
    </table>

    <h3>Schedule</h3>
    <p>
        Day: {{ $schedule->available_day }} <br>
        Time: {{ $schedule->start_time }} - {{ $schedule->end_time }}
    </p>

    <h3>Notes</h3>
    <p>{{ $appointment->notes ?? 'No notes provided' }}</p>
</body>
<script>
document.getElementById('doctor_id').addEventListener('change', function() {
    let doctorId = this.value;
    let timeSlotSelect = document.getElementById('time_slot');
    timeSlotSelect.innerHTML = '<option>Loading...</option>';

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

</html>
