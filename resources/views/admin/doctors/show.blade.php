@extends('admin.home')

@section('doctors')
    <div class="container">
        <h2>Doctor Details</h2>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary mb-3">Back to Doctors List</a>

        <div class="card">
            <div class="card-header">
                <h3>{{ $doctor->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $doctor->email }}</p>
                <p><strong>Contact No:</strong> {{ $doctor->contact }}</p>
                <p><strong>Address:</strong> {{ $doctor->address }}</p>
                <p><strong>Country:</strong> {{ $doctor->country }}</p>
                <p><strong>Date of Birth:</strong> {{ $doctor->date_of_birth }}</p>
                <p><strong>Date of Joining:</strong> {{ $doctor->date_of_joining }}</p>
                <p><strong>Blood Group:</strong> {{ $doctor->blood_group }}</p>
                @if($doctor->profile_image)
                    <p><strong>Profile Image:</strong></p>
                    <img src="{{ asset('images/' . $doctor->profile_image) }}" alt="Profile Image" style="max-width: 150px;">
                <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Designation:</strong> {{ $doctor->designation }}</p>
                <p><strong>Department:</strong> {{ $doctor->department }}</p>
                <p><strong>License Number:</strong> {{ $doctor->license_number }}</p>
                <p><strong>Work Experience:</strong> {{ $doctor->work_experience }} years</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-warning">Edit Details</a>
                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete Doctor</button>
                </form>
            </div>
        </div>
    </div>
@endsection