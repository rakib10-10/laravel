@extends('layouts.patient_home')

@section('content')
<div class="container mt-4">
    <h1>Welcome, {{ $user->name }}</h1>

    <div class="card mb-4">
        <div class="card-header">Next Appointment</div>
        <div class="card-body">
            @if($nextAppointment)
                <p><strong>Doctor:</strong> {{ $nextAppointment->doctor->name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d M Y, h:i A') }}</p>
            @else
                <p>You have no upcoming appointments.</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">Recent Activities</div>
        <div class="card-body">
            @if($recentActivities->count())
                <ul class="list-group">
                    @foreach($recentActivities as $appointment)
                        <li class="list-group-item">
                            <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y, h:i A') }}</strong> with Dr. {{ $appointment->doctor->name }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No recent activities found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
