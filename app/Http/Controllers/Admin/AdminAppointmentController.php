<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\DoctorSchedule;

class AdminAppointmentController extends Controller
{
    // Show appointment creation form
    public function create()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('admin.appointments.create', compact('doctors', 'patients'));
    }

    // Store new appointment
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'available_day'   => 'required|string',
            'time_slot'       => 'required|string',
            'notes'           => 'nullable|string',
            'start_time'      => 'required',
            'end_time'        => 'required',
        ]);

        $appointment = Appointment::create([
            'patient_id'       => $validatedData['patient_id'],
            'doctor_id'        => $validatedData['doctor_id'],
            'available_day'    => $validatedData['available_day'],
            'appointment_date' => $validatedData['appointment_date'],
            'time_slot'        => $validatedData['time_slot'],
            'start_time'       => $validatedData['start_time'],
            'end_time'         => $validatedData['end_time'],
            'notes'            => $validatedData['notes'] ?? '',
            'status'           => 'pending'
        ]);

        return redirect()->route('admin.appointments.show', $appointment->id)
                         ->with('success', 'Appointment booked successfully!');

    } catch (\Exception $e) {
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Error creating appointment: ' . $e->getMessage());
    }
}
    // Show single appointment confirmation
    public function show($id)
    {
        try {
            // Load the appointment with relationships
            $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
            
            return view('admin.appointment-confirmation', compact('appointment'));
            
        } catch (\Exception $e) {
            return redirect()->route('admin.appointments.index')
                             ->with('error', 'Appointment not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
        $doctors = Doctor::all();
        $patients = Patient::all();
        
        return view('admin.appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'available_day'   => 'required|string',
            'time_slot'       => 'required|string',
            'start_time'      => 'required',
            'end_time'        => 'required',
            'status'          => 'required|in:pending,confirmed,completed,cancelled',
            'notes'           => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);

        return redirect()->route('admin.appointments.show', $appointment->id)
                         ->with('success', 'Appointment updated successfully!');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $appointment->status
            ]);
        }

        return redirect()->back()->with('success', 'Appointment status updated!');
    }

    // List all appointments
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])
                                  ->orderBy('appointment_date', 'desc')
                                  ->orderBy('start_time', 'desc')
                                  ->paginate(10);
        
        return view('admin.appointments.index', compact('appointments'));
    }

    // Fetch doctor schedules (AJAX)
    public function getSchedules($doctorId)
    {
        try {
            $schedules = DoctorSchedule::where('doctor_id', $doctorId)
                ->select('available_day', 'start_time', 'end_time')
                ->get();

            return response()->json([
                'schedules' => $schedules
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}