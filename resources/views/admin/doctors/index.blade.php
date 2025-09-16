@extends('admin.home')
@section('doctors')
    <div class="container">
        <h2>ALL DOCTORS</h2>
        
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-success mb-3">Add New Doctor</a>

        @foreach($doctors as $doctor)
            <div class="doctor-card">
                <div class="doctor-image">
                    <img src="{{ asset('images/' . $doctor->profile_image) }}" alt="Doctor Image">
                </div>
                <div class="doctor-details">
                    <p><strong>Doctor Name:</strong> {{ $doctor->name }}</p>
                    <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                    <p><strong>Contact No:</strong> {{ $doctor->phone }}</p>
                    <p><strong>Email:</strong> {{ $doctor->email }}</p>
                    <div class="doctor-buttons">
                        <a href="{{ url('/doctor/' . $doctor->id) }}" class="btn btn-primary">View Details</a>
                        <a href="{{ url('/doctor/' . $doctor->id) }}/edit" class="btn btn-warning">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection