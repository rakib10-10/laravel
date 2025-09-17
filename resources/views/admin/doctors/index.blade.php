@extends('admin.home')
@section('doctors')
    <div class="container">
        <h2 class="mb-4">ALL DOCTORS</h2>

        <div class="row">
            @foreach ($doctors as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="doctor-image mb-3">
                                @if ($doctor->profile_image)
                                    <img src="{{ asset('images/' . $doctor->profile_image) }}" 
                                         alt="{{ $doctor->name }} Profile Image" 
                                         class="rounded-circle img-fluid" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/1758054991.b2f1c346-4b0c-4426-aefa-e79008be4b5d.jpg') }}" 
                                         alt="Default Avatar" 
                                         class="rounded-circle img-fluid" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            </div>

                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="card-text"><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                            <p class="card-text"><strong>Contact:</strong> {{ $doctor->phone ?? $doctor->contact ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Email:</strong> {{ $doctor->email }}</p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
