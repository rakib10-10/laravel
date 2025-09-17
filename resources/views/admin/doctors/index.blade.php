@extends('admin.home')
@section('doctors')
    <div class="container">
        <h2>ALL DOCTORS</h2>

        {{-- <a href="{{ route('admin.doctors.create') }}" class="btn btn-success mb-3">Add New Doctor</a> --}}

        @foreach ($doctors as $doctor)
            <div class="doctor-card">
                <div class="doctor-card">
                    <div class="doctor-image">
                        @if ($doctor->profile_image)
                            <img src="{{ asset('images/' . $doctor->profile_image) }}" alt="{{ $doctor->name }}">
                        @else
                            <img src="{{ asset('images/1758054991.b2f1c346-4b0c-4426-aefa-e79008be4b5d.jpg') }}" alt="Default Avatar" width="150"height="150">
                        @endif
                    </div>
                </div>
                
                <div class="doctor-details">
                    <p><strong>Doctor Name:</strong> {{ $doctor->name }}</p>
                    <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                    <p><strong>Contact No:</strong> {{ $doctor->phone }} {{ $doctor->contact ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $doctor->email }}</p>
                    <div class="doctor-buttons">
                        <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="btn btn-primary">View Details</a>
                        <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-warning">Edit</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
