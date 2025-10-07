<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;      // Mock model
use App\Models\Patient;     // Mock model
use App\Models\Appointment; // <-- ADDED: Required for method type-hinting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Example: $appointments = Appointment::with(['patient', 'doctor'])->paginate(15);
        $appointments = collect([]); // Placeholder
        return view('admin.appointments.index', compact('appointments'));
    } 
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch data needed for the creation form (e.g., all doctors and patients)
        $doctors = Doctor::all();
        $patients = Patient::all();

        return view('admin.appointments.create', compact('doctors', 'patients'));
    }
    
    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'available_day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        // Appointment::create([...]); // Persistence logic goes here

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment successfully booked!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        // Fetch $doctors and $patients if needed for the edit form
        return view('admin.appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Update validation and persistence logic goes here
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // $appointment->delete();
        // return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted.');
    }

    /**
     * Handles the AJAX request for a doctor's schedule.
     */
    public function getSchedules(Doctor $doctor)
    {
        // Mock schedule data for demonstration purposes
        $schedules = [
            ['available_day' => 'Monday', 'start_time' => '09:00', 'end_time' => '12:00'],
            ['available_day' => 'Monday', 'start_time' => '14:00', 'end_time' => '17:00'],
            ['available_day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '13:00'],
            ['available_day' => 'Friday', 'start_time' => '08:00', 'end_time' => '11:00'],
        ];

        return response()->json(['schedules' => $schedules]);
    }
}
