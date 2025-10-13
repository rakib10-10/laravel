<?php

namespace App\Http\Controllers\Doctor; // Namespace must include 'Doctor'

use App\Http\Controllers\Controller; // Use the base Controller class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class DoctorAppointmentController extends Controller
{
    /**
     * Display a listing of appointments assigned to the logged-in doctor.
     */
    public function index()
    {
        $doctorId = Auth::id();

        // Logic to fetch only appointments assigned to the current doctor
        $appointments = Appointment::where('doctor_id', $doctorId)
                                   ->with('patient') // Eager load patient details
                                   ->latest()
                                   ->paginate(15);

        // This view will show the doctor's schedule/list of appointments
        return view('doctor.appointments.index', compact('appointments'));
    }

    /**
     * Update the status of a specific appointment (e.g., confirmed, cancelled, completed).
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Authorization check: Ensure the doctor owns this appointment
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => ['required', 'string', 'in:confirmed,cancelled,completed'],
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return back()->with('success', 'Appointment status updated successfully.');
    }
}
