@extends('layouts.doctor_home')

@section('content')
<div class="container">
    <h1>My Appointments</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->patient->user->name ?? '-' }}</td>
                <td>{{ $appointment->date }}</td>
                <td>{{ $appointment->time }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
