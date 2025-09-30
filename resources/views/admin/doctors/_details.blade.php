<div class="card p-3">
    <h3>Doctor Profile</h3>
    <div style="display:flex; gap:16px; align-items:flex-start;">
        <img src="{{ $doctor->profile_image ? asset('images/' . $doctor->profile_image) : asset('images/default-doctor.png') }}" 
             alt="Doctor Image"
             style="width:100px; height:100px; border-radius:50%; border:2px solid #ddd;">
        <div>
            <p><strong>Name:</strong> {{ $doctor->name }}</p>
            <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
            <p><strong>Email:</strong> {{ $doctor->email }}</p>
            <p><strong>Contact:</strong> {{ $doctor->contact }}</p>
            <p><strong>Bio:</strong> {{ $doctor->bio }}</p>
        </div>
    </div>

    {{-- Doctor schedules --}}
    @if($doctor->schedules && $doctor->schedules->count() > 0)
        <div class="mt-3">
            <h4>Available Schedules</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Day</th>
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
        </div>
    @else
        <p class="mt-3 text-muted">No schedules available.</p>
    @endif
</div>
