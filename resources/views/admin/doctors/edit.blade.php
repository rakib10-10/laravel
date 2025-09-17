@extends('admin.home')

@section('doctors')
    <div class="container">
        <h2>Edit Doctor</h2>

        {{-- Add enctype="multipart/form-data" to the form --}}
        <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group mb-3">
                <label for="name">Doctor Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $doctor->name) }}">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email', $doctor->email) }}">
            </div>

            {{-- Add the file input field for the profile image --}}
            <div class="form-group mb-3">
                <label for="profile_image">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image">
                @if($doctor->profile_image)
                    <p class="mt-2">Current Image: <img src="{{ asset('images/' . $doctor->profile_image) }}" alt="Current Profile Image" style="max-width: 100px;"></p>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="contact">Contact No</label>
                <input type="tel" class="form-control" id="contact" name="contact" value="{{ old('contact', $doctor->contact) }}">
            </div>

            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $doctor->address) }}">
            </div>
            
            <div class="form-group mb-3">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $doctor->country) }}">
            </div>

            <div class="form-group mb-3">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $doctor->date_of_birth) }}">
            </div>

            <div class="form-group mb-3">
                <label for="date_of_joining">Date of Joining</label>
                <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" value="{{ old('date_of_joining', $doctor->date_of_joining) }}">
            </div>

            <div class="form-group mb-3">
                <label for="blood_group">Blood Group</label>
                <select class="form-control" id="blood_group" name="blood_group">
                    <option value="" disabled selected>Select Blood Group</option>
                    <option value="A+" {{ old('blood_group', $doctor->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ old('blood_group', $doctor->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ old('blood_group', $doctor->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ old('blood_group', $doctor->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="O+" {{ old('blood_group', $doctor->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ old('blood_group', $doctor->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                    <option value="AB+" {{ old('blood_group', $doctor->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ old('blood_group', $doctor->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="specialist">Specialist</label>
                <input type="text" class="form-control" id="specialist" name="specialist" value="{{ old('specialist', $doctor->specialist) }}">
            </div>
            
            <div class="form-group mb-3">
                <label for="specialization">Specialization</label>
                <input type="text" class="form-control" id="specialization" name="specialization" required value="{{ old('specialization', $doctor->specialization) }}">
            </div>

            <div class="form-group mb-3">
                <label for="department">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="{{ old('department', $doctor->department) }}">
            </div>

            <div class="form-group mb-3">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', $doctor->designation) }}">
            </div>
            
            <div class="form-group mb-3">
                <label for="work_experience">Work Experience (Years)</label>
                <input type="number" class="form-control" id="work_experience" name="work_experience" value="{{ old('work_experience', $doctor->work_experience) }}">
            </div>

            <div class="form-group mb-3">
                <label for="license_number">License Number</label>
                <input type="text" class="form-control" id="license_number" name="license_number" required value="{{ old('license_number', $doctor->license_number) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Doctor</button>
        </form>
    </div>
@endsection