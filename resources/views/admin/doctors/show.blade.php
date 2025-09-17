@extends('admin.home')

@section('doctors')
<div class="container mt-4">
    <h2 class="mb-4">Doctor Profile</h2>
    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary mb-3">Back to Doctors List</a>

    <div class="card shadow-sm">
        <div class="row g-0 p-3">
            {{-- Profile Image Section --}}
            <div class="col-md-3 text-center">
                @if($doctor->profile_image)
                    <img src="{{ asset('images/' . $doctor->profile_image) }}" 
                         alt="Profile Image" 
                         class="img-fluid rounded-circle border border-secondary mb-3"
                         style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/1758054991.b2f1c346-4b0c-4426-aefa-e79008be4b5d.jpg') }}" 
                         alt="Default Profile" 
                         class="img-fluid rounded-circle border border-secondary mb-3"
                         style="width: 150px; height: 150px; object-fit: cover;">
                @endif
                <h4 class="mt-2">{{ $doctor->name }}</h4>
                <p class="text-muted">{{ $doctor->designation }}</p>
            </div>

            {{-- Details Section --}}
            <div class="col-md-9">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Email:</strong> {{ $doctor->email }}</div>
                        <div class="col-md-6"><strong>Contact:</strong> {{ $doctor->contact }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Address:</strong> {{ $doctor->address }}</div>
                        <div class="col-md-6"><strong>Country:</strong> {{ $doctor->country }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Date of Birth:</strong> {{ $doctor->date_of_birth }}</div>
                        <div class="col-md-6"><strong>Date of Joining:</strong> {{ $doctor->date_of_joining }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Blood Group:</strong> {{ $doctor->blood_group }}</div>
                        <div class="col-md-6"><strong>License Number:</strong> {{ $doctor->license_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Specialization:</strong> {{ $doctor->specialization }}</div>
                        <div class="col-md-6"><strong>Department:</strong> {{ $doctor->department }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Work Experience:</strong> {{ $doctor->work_experience }} years</div>
                    </div>
                </div>

                {{-- Card Footer with Actions --}}
                <div class="d-flex justify-content-end p-3">
                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-warning me-2">Edit</a>
                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
