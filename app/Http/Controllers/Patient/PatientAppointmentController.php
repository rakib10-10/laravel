<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Slot;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    /**
     * Show the appointment booking form.
     */
    public function create()
    {
        $doctors = Doctor::all();

        return view('patient.appointments.create', compact('doctors'));
    }

    /**
     * Fetch available slots for a doctor on a given date.
     */
    public function getSchedules(Request $request, Doctor $doctor)
    {
        $date = $request->query('date');

        if (! $date) {
            return response()->json([
                'success' => false,
                'message' => 'Date is required.',
            ]);
        }

        // --- START MODIFICATION ---
        // 1. Removed ->where('is_booked', false) to fetch ALL slots for the date.
        // 2. Added 'is_booked' to the map to inform the frontend of the slot status.
        $slots = Slot::where('doctor_id', $doctor->id)
            ->where('slot_date', $date)
            ->orderBy('start_time') // Added ordering for better display
            ->get()
            ->map(fn ($slot) => [
                'id' => $slot->id,
                'slot_date' => $slot->slot_date,
                'is_booked' => (bool) $slot->is_booked, // Ensure boolean type for frontend
                'display' => date('H:i', strtotime($slot->start_time)).' - '.date('H:i', strtotime($slot->end_time)),
            ]);
        // --- END MODIFICATION ---

        return response()->json([
            'success' => true,
            'slots' => $slots,
        ]);
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'slot_id' => 'required|exists:slots,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'patient_name' => 'required|string|max:255',
        ]);

        $user = $request->user();

        // Ensure patient exists with name
        $patient = Patient::updateOrCreate(
            ['user_id' => $user->id],
            ['name' => $request->patient_name]
        );

        $slot = Slot::findOrFail($request->slot_id);

        // Check for slot conflicts (though marking slot as booked should prevent this)
        if ($slot->is_booked) {
            return back()->withErrors(['slot_id' => 'This slot has just been booked by another user. Please choose another time.'])->withInput();
        }

        // Removed Appointment conflict check here since we rely on the Slot 'is_booked' flag.
        // If the 'is_booked' flag is managed correctly, checking the Appointment table is redundant.
        /*
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->scheduled_date)
            ->where('start_time', $slot->start_time)
            ->where('end_time', $slot->end_time)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->first();

        if ($conflict) {
            return back()->withErrors(['slot_id' => 'This slot is already booked.'])->withInput();
        }
        */

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->scheduled_date,
            'start_time' => $slot->start_time,
            'end_time' => $slot->end_time,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);

        // Mark the slot as booked immediately after successful appointment creation
        $slot->update(['is_booked' => 1]);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment booked successfully!');
    }

    /**
     * Display logged-in patient's appointments.
     */
    public function index()
    {
        $user = auth()->user();

        // Find the patient record for this user
        $patient = Patient::where('user_id', $user->id)->first();

        if (! $patient) {
            $appointments = collect(); // empty collection
        } else {
            $appointments = Appointment::with('doctor')
                ->where('patient_id', $patient->id)
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
        }

        return view('patient.appointments.index', compact('appointments', 'user'));
    }

    /**
     * Display details of a specific appointment.
     */
    public function show(Appointment $appointment)
    {
        $user = auth()->user();

        // Make sure the appointment belongs to this patient
        $patient = Patient::where('user_id', $user->id)->first();
        if (! $patient || $appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        // Load doctor relation
        $appointment->load('doctor');

        return view('patient.appointments.show', compact('appointment', 'user'));
    }

    public function destroy(Appointment $appointment)
    {
        if (auth()->id() !== $appointment->patient->user_id) {
            abort(403);
        }

        if ($appointment->status === 'Pending') {
            // Need to unmark the slot as booked before deleting the appointment
            // This assumes a relationship exists between Appointment and Slot, or a way to derive the slot
            
            // Temporary simple fix: find the associated slot and unbook it
            $slot = Slot::where('doctor_id', $appointment->doctor_id)
                ->where('slot_date', $appointment->appointment_date)
                ->where('start_time', $appointment->start_time)
                ->where('end_time', $appointment->end_time)
                ->first();

            if ($slot) {
                $slot->update(['is_booked' => 0]);
            }
            
            $appointment->delete();

            return redirect()->route('patient.appointments.index')->with('success', 'Appointment canceled successfully.');
        }

        return redirect()->route('patient.appointments.index')->with('error', 'Only pending appointments can be canceled.');
    }

    public function dashboard()
    {
        $user = auth()->user(); // Get the currently logged-in user

        // --- START FIX ---
        // 1. Find the Patient record associated with the authenticated User
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            // If the patient record doesn't exist, initialize empty collections
            $nextAppointment = null;
            $upcomingAppointments = collect();
            $recentActivities = collect();
        } else {
            // Set the start of the current day (for general filtering)
            $startOfToday = now()->startOfDay();
            // Use the current exact time (for finding the single next appointment)
            $now = now(); 
            
            // Use the $patient's appointments relationship (if defined on Patient model) 
            // OR explicitly query where patient_id matches $patient->id
            $baseQuery = Appointment::with('doctor')->where('patient_id', $patient->id);

            // 1. Fetch the single next appointment (upcoming, confirmed/pending)
            $nextAppointment = (clone $baseQuery)
                ->where('appointment_date', '>=', $now) // Filter from the current exact time onward
                ->whereIn('status', ['Confirmed', 'Pending']) // Status check
                ->orderBy('appointment_date')
                ->first();

            // 2. Fetch all future appointments
            $upcomingAppointments = (clone $baseQuery)
                ->where('appointment_date', '>=', $startOfToday) // Filter from start of today
                ->whereIn('status', ['Confirmed', 'Pending']) // Status check
                ->orderBy('appointment_date')
                ->get();

            // 3. Fetch recent activities (e.g., last 5 completed/cancelled appointments)
            $recentActivities = (clone $baseQuery)
                ->whereIn('status', ['Completed', 'Cancelled'])
                ->orderByDesc('appointment_date')
                ->limit(5)
                ->get();
        }
        // --- END FIX ---

        return view('patient.dashboard', compact('user', 'nextAppointment', 'recentActivities', 'upcomingAppointments'));
    }
}
