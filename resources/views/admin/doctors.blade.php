@extends('admin.home')
@section('doctors')
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Doctors</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 1000px;
      margin: 20px auto;
    }
    h2 {
      text-align: left;
      color: #007BFF;
    }
    .doctor-card {
      display: flex;
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    .doctor-image {
      flex: 1;
      margin-right: 20px;
    }
    .doctor-image img {
      width: 100%;
      max-width: 180px;
      border-radius: 8px;
    }
    .doctor-details {
      flex: 3;
    }
    .doctor-details p {
      margin: 8px 0;
    }
    .doctor-buttons {
      margin-top: 10px;
    }
    .doctor-buttons button {
      margin-right: 10px;
      padding: 8px 12px;
      background-color: #007BFF;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    .doctor-buttons button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>ALL DOCTORS</h2>

  <!-- Doctor 1 -->
  <div class="doctor-card">
    <div class="doctor-image">
      <img src="{{asset('images/rakib.jpg')}}" alt="Doctor J.M. Wadhwan">
    </div>
    <div class="doctor-details">
      <p><strong>Doctor Name:</strong> Rakib Bhuiyan</p>
      <p><strong>Doctor Type:</strong> Neuorologist</p>
      <p><strong>Contact No:</strong> +8801316787455</p>
      <p><strong>Email:</strong> rakibbhuiyan@gmail.com</p>
      <p><strong>Qualification:</strong> Ph.D</p>
      <div class="doctor-buttons">
    <a href="{{ url('/doctor/details') }}">
        <button>View Details</button>
    </a>
    <button>View Timings</button>
    <button>Book Appointments</button>
</div>

    </div>
  </div>

  <!-- Doctor 2 -->
  <div class="doctor-card">
    <div class="doctor-image">
      <img src="{{asset('images/riya.jpg')}}" alt="Doctor Riya Datta">
    </div>
    <div class="doctor-details">
      <p><strong>Doctor Name:</strong> Riya Datta</p>
      <p><strong>Doctor Type:</strong> Surgeon</p>
      <p><strong>Contact No:</strong> +014785487</p>
      <p><strong>Email:</strong> riyadatta@gmail.com</p>
      <p><strong>Qualification:</strong> M.Phil, Ph.D</p>
      <div class="doctor-buttons">
        <button>View Details</button>
        <button>View Timings</button>
        <button>Book Appointments</button>
      </div>
    </div>
  </div>
  {{-- Doctor 3 --}}
  <div class="doctor-card">
    <div class="doctor-image">
      <img src="{{asset('images/shihab.jpg')}}" alt="Doctor Riduan Shihab">
    </div>
    <div class="doctor-details">
      <p><strong>Doctor Name:</strong> Riduan Shihab</p>
      <p><strong>Doctor Type:</strong> Dentist</p>
      <p><strong>Contact No:</strong> +017845454</p>
      <p><strong>Email:</strong> riduanshihab@gmail.com</p>
      <p><strong>Qualification:</strong> M.Phil, Ph.D</p>
      <div class="doctor-buttons">
        <button>View Details</button>
        <button>View Timings</button>
        <button>Book Appointments</button>
      </div>
    </div>
  </div>
   {{-- Doctor 4 --}}
  <div class="doctor-card">
    <div class="doctor-image">
      <img src="{{asset('images/pranta.jpg')}}" alt="Doctor Fayez Saletin">
    </div>
    <div class="doctor-details">
      <p><strong>Doctor Name:</strong> Fayez Salehin</p>
      <p><strong>Doctor Type:</strong> Physicist</p>
      <p><strong>Contact No:</strong> +0178945321</p>
      <p><strong>Email:</strong> salehinpranta@gmail.com</p>
      <p><strong>Qualification:</strong> M.Phil, Ph.D</p>
      <div class="doctor-buttons">
        <button>View Details</button>
        <button>View Timings</button>
        <button>Book Appointments</button>
      </div>
    </div>
  </div>
</div>
{{-- Add doctor --}}
<div class="container">
  <h2 class="mb-4">Add New Doctor</h2>
  {{-- <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data"> --}}
    {{-- @csrf --}}
    <div class="row mb-3">
      <div class="col-md-6"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
      <div class="col-md-6"><input type="number" name="age" class="form-control" placeholder="Age" required></div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6"><input type="text" name="phone" class="form-control" placeholder="Phone Number" required></div>
      <div class="col-md-6"><input type="text" name="address" class="form-control" placeholder="Address" required></div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
      <div class="col-md-6"><input type="date" name="date_of_birth" class="form-control" required></div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6"><input type="date" name="date_of_joining" class="form-control" required></div>
      <div class="col-md-6"><input type="text" name="blood_group" class="form-control" placeholder="Blood Group" required></div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6"><input type="text" name="department" class="form-control" placeholder="Department" required></div>
      <div class="col-md-6"><input type="number" name="experience" class="form-control" placeholder="Experience (Years)" required></div>
    </div>
    <div class="mb-3">
      <label>Specialists</label>
      <select name="specialists[]" multiple class="form-control">
        <option value="Cardiomyopathy">Cardiomyopathy</option>
        <option value="Arrhythmia">Arrhythmia</option>
        <option value="Hypertension">Hypertension</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Designations</label>
      <select name="designations[]" multiple class="form-control">
        <option value="MD - Medicine">MD - Medicine</option>
        <option value="DM - Cardiology">DM - Cardiology</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Profile Image</label>
      <input type="file" name="profile_image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save Doctor</button>
  </form>
</div>


</body>
</html>
@endsection