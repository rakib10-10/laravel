@extends('admin.home')

@section('content')
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

        <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="profile_image">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image">
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
            <hr class="my-4">

            <h3>Add Doctor Schedules</h3>
            <div id="schedule-container">
                </div>
            <button type="button" class="btn btn-secondary mb-3" id="add-schedule">Add Schedule</button>
            <button type="submit" class="btn btn-primary">Save Doctor</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('schedule-container');
            const addButton = document.getElementById('add-schedule');
            let scheduleIndex = 0;

            // Function to create and append a new schedule block
            function addScheduleBlock() {
                const newScheduleBlock = document.createElement('div');
                newScheduleBlock.classList.add('schedule-block', 'p-3', 'border', 'rounded', 'mb-3');
                newScheduleBlock.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="available_day_${scheduleIndex}">Available Day</label>
                                <select class="form-control" id="available_day_${scheduleIndex}" name="schedules[${scheduleIndex}][available_day]" required>
                                    <option value="" disabled selected>Select Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="start_time_${scheduleIndex}">Start Time</label>
                                <input type="time" class="form-control" id="start_time_${scheduleIndex}" name="schedules[${scheduleIndex}][start_time]" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="end_time_${scheduleIndex}">End Time</label>
                                <input type="time" class="form-control" id="end_time_${scheduleIndex}" name="schedules[${scheduleIndex}][end_time]" required>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-schedule">Remove</button>
                        </div>
                    </div>
                `;
                container.appendChild(newScheduleBlock);
                scheduleIndex++;
            }

            // Event listener for the "Add Schedule" button
            addButton.addEventListener('click', addScheduleBlock);

            // Event listener for the "Remove" button (uses event delegation)
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-schedule')) {
                    e.target.closest('.schedule-block').remove();
                }
            });

            // Add one schedule block by default on page load
            addScheduleBlock();
        });
    </script>

@endsection