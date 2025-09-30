{{-- @extends('admin.home') {{-- If you already have an admin layout --}}

{{-- @section('content')
<div class="appointment-container">
    <h2>Book an Appointment</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

        <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">

        <label for="doctor">Choose Doctor:</label>
        <select name="doctor_id" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">
                    {{ $doctor->name }} ({{ $doctor->specialization->name ?? 'No Specialization' }})
                </option>
            @endforeach
        </select>

        <label for="date">Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" required>

        <label for="notes">Notes:</label>
        <textarea name="notes" placeholder="Additional notes"></textarea>

        <button type="submit">Book Appointment</button>
    </form>
</div>
@endsection --}} 
