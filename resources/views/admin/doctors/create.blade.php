@extends('admin.home')

@section('doctors')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h2>Add New Doctor</h2>

        <form action="{{ route('admin.doctors.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Doctor Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required
                    value="{{ old('email') }}">
            </div>

            <div class="form-group mb-3">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required
                    value="{{ old('date_of_birth') }}">
            </div>

            <div class="form-group mb-3">
                <label for="date_of_joining">Date of Joining</label>
                <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" required
                    value="{{ old('date_of_joining') }}">
            </div>

            <div class="form-group mb-3">
                <label for="blood_group">Blood Group</label>
                <select class="form-control" id="blood_group" name="blood_group" required>
                    <option value="" disabled selected>Select Blood Group</option>
                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="license_number">License Number</label>
                <input type="text" class="form-control" id="license_number" name="license_number" required
                    value="{{ old('license_number') }}">
            </div>

            <div class="form-group mb-3">
                <label for="specialist">Specialist</label>
                <select class="form-control" id="specialist" name="specialist" required>
                    <option value="" disabled selected>Select Specialist Area</option>
                    <option value="Cardiomyopathy" {{ old('specialist') == 'Cardiomyopathy' ? 'selected' : '' }}>
                        Cardiomyopathy</option>
                    <option value="Arrhythmia" {{ old('specialist') == 'Arrhythmia' ? 'selected' : '' }}>Arrhythmia
                    </option>
                    <option value="Hypertension" {{ old('specialist') == 'Hypertension' ? 'selected' : '' }}>Hypertension
                    </option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
            </div>
            <div class="form-group mb-3">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
            </div>
            <div class="form-group mb-3">
                <label for="contact">Contact No</label>
                <input type="tel" class="form-control" id="contact" name="contact" value="{{ old('contact') }}">
            </div>
            <div class="form-group mb-3">
                <label for="specialization">Specialization</label>
                <input type="text" class="form-control" id="specialization" name="specialization" required
                    value="{{ old('specialization') }}">
            </div>

            <div class="form-group mb-3">
                <label for="department">Department</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="Cardiology" {{ old('department') == 'Cardiology' ? 'selected' : '' }}>Cardiology
                    </option>
                    <option value="Neurology" {{ old('department') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                    <option value="General Surgery" {{ old('department') == 'General Surgery' ? 'selected' : '' }}>General
                        Surgery</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="designation">Designation</label>
                <select class="form-control" id="designation" name="designation" required>
                    <option value="" disabled selected>Select Designation</option>
                    <option value="MD - Medicine" {{ old('designation') == 'MD - Medicine' ? 'selected' : '' }}>MD -
                        Medicine</option>
                    <option value="DM - Cardiology" {{ old('designation') == 'DM - Cardiology' ? 'selected' : '' }}>DM -
                        Cardiology</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="work_experience">Work Experience (Years)</label>
                <input type="number" class="form-control" id="work_experience" name="work_experience" required
                    value="{{ old('work_experience') }}">
            </div>

            <button type="submit" class="btn btn-primary">Save Doctor</button>
        </form>
    </div>
@endsection
