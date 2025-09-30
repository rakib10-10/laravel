<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;


class AppointmentController extends Controller
{
    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        // Fetch all doctors to populate the dropdown
        $doctors = Doctor::all();
        return view('admin.appointment', compact('doctors'));
    }

    /**
     * Store a newly created appointment in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // 2. Create the appointment record
        $appointment = Appointment::create($validatedData + ['status' => 'pending']);

        // 3. Redirect to the confirmation page with the appointment data
        return redirect()->route('admin.appointment.show', $appointment->id);
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        // This method will display the confirmation page
        // It uses route model binding to fetch the appointment
        return view('admin.appointment-confirmation', compact('appointment'));
    }

    /**
     * Fetch doctor's schedules.
     */
    public function getSchedules($doctorId)
{
    $schedules = DoctorSchedule::where('doctor_id', $doctorId)->get();

    return response()->json([
        'schedules' => $schedules
    ]);
}
}