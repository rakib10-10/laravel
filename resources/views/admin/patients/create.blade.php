@extends('admin.home')

@section('content')
<h2 class="page-title">Add New Patient</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.patients.store') }}" method="POST">
    @csrf
    
    <div class="form-group mb-3">
        <label for="name">Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
    </div>
    
    <div class="form-group mb-3">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
    </div>

    <div class="form-group mb-3">
        <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="gender">Gender <span class="text-danger">*</span></label>
        <select class="form-control" id="gender" name="gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="blood_type">Blood Type <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="blood_type" name="blood_type" value="{{ old('blood_type') }}" required>
    </div>
    
    <div class="form-group mb-3">
        <label for="address">Address <span class="text-danger">*</span></label>
        <textarea class="form-control" id="address" name="address" required>{{ old('address') }}</textarea>
    </div>

    <div class="form-group mb-3">
        <label for="emergency_contact">Emergency Contact <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
    </div>
    
    <button type="submit" class="btn btn-success">Add Patient</button>
    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection