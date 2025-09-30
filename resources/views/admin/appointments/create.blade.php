{{-- @extends('admin.home')

@section('content')
<style>
    .doctor-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        padding: 20px;
        margin-bottom: 25px;
    }
    .doctor-card img {
        width: 100px; height: 100px;
        border-radius: 50%; object-fit: cover;
        border: 2px solid #ddd;
    }
</style>

<div class="container">
    <h1 class="mb-4">Book an Appointment</h1>

    {{-- Filter by specialization --}}
    {{-- <div class="mb-4">
        <label><strong>Filter by Specialization:</strong></label>
        <select id="specializationFilter" class="form-control" onchange="filterDoctors()">
            <option value="">All</option>
            @foreach($specializations as $specialization)
                <option value="{{ $specialization }}">{{ $specialization }}</option>
            @endforeach
        </select>
    </div>

    {{-- Doctor List --}}
    {{-- <div id="doctorList">
        @foreach($doctors as $doctor)
            <div class="doctor-card" data-specialization="{{ $doctor->specialization }}">
                <div style="display:flex; gap:16px; align-items:flex-start;">
                    <img src="{{ $doctor->profile_image ? asset('images/'.$doctor->profile_image) : asset('images/default-doctor.png') }}">
                    <div>
                        <h4>{{ $doctor->name }}</h4>
                        <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                        <p><strong>Email:</strong> {{ $doctor->email }}</p>
                        <p><strong>Contact:</strong> {{ $doctor->contact }}</p>
                        <p>{{ $doctor->bio }}</p>

                        {{-- Schedule --}}
                        {{-- @if($doctor->schedules->count() > 0)
                            <form action="{{ route('admin.appointments.store') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                <div class="form-group">
                                    <label>Choose Day:</label>
                                    <select name="available_day" class="form-control" required>
                                        @foreach($doctor->schedules as $schedule)
                                            <option value="{{ $schedule->available_day }}">
                                                {{ $schedule->available_day }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Choose Time:</label>
                                    <select name="time_slot" class="form-control" required>
                                        @foreach($doctor->schedules as $schedule)
                                            <option value="{{ $schedule->start_time }}-{{ $schedule->end_time }}">
                                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Appointment Date:</label>
                                    <input type="date" name="appointment_date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Describe your issue (optional)"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Book Appointment</button>
                            </form>
                        @else
                            <p class="text-muted">No schedules available.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function filterDoctors() {
    const filter = document.getElementById("specializationFilter").value.toLowerCase();
    document.querySelectorAll("#doctorList .doctor-card").forEach(card => {
        const specialization = card.getAttribute("data-specialization").toLowerCase();
        card.style.display = (filter === "" || specialization === filter) ? "block" : "none";
    });
}
</script>  --}}
{{-- @endsection   --}}
