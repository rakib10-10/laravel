@extends('admin.home')

@section('appointment')
<style>
    .confirmation-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 40px;
        background: #e6f7ff;
        border-radius: 15px;
        border: 2px solid #a8dadc;
        text-align: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .confirmation-container h1 {
        color: #1d3557;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .confirmation-container p {
        color: #457b9d;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .details-box {
        background: #ffffff;
        padding: 25px;
        border-radius: 10px;
        text-align: left;
        border: 1px solid #e0e0e0;
    }

    .details-box h3 {
        color: #1d3557;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .details-box strong {
        color: #457b9d;
        display: inline-block;
        width: 150px;
    }

    .details-box span {
        font-weight: 500;
        color: #666;
    }
</style>

<div class="confirmation-container">
    <h1>Appointment Booked!</h1>
    <p>Your appointment has been successfully scheduled. We look forward to seeing you!</p>
    
    <div class="details-box">
        <h3>Appointment Details</h3>
        <p><strong>Doctor:</strong> <span>{{ $appointment->doctor->name }}</span></p>
        <p><strong>Date:</strong> <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</span></p>
        <p><strong>Status:</strong> <span>{{ ucfirst($appointment->status) }}</span></p>
        @if($appointment->notes)
            <p><strong>Notes:</strong> <span>{{ $appointment->notes }}</span></p>
        @endif
    </div>
</div>
@endsection