<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
// Assuming this model exists
use Illuminate\Http\Request;      // Assuming this model exists
use Illuminate\Support\Facades\Auth;

class PatientAppointmentController extends Controller
{
    /**
     * Display a listing of the logged-in patient's appointments.
     */
    public function index()
    {
        $patientId = Auth::id();

        $appointments = Appointment::where('patient_id', $patientId)
            ->with('doctor') // Eager load doctor details
            ->latest()
            ->paginate(15);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        // Fetch all doctors available for appointments
        $doctors = Doctor::all();

        // This view will contain the form asking for doctor, date, and reason,
        // and will use AJAX to fetch schedules using getSchedules().
        return view('patient.appointments.create', compact('doctors'));
    }

    /**
     * Fetches available appointment schedules for a given doctor by translating
     * recurring schedules into a list of specific upcoming dates and slots.
     * This is called via AJAX from the appointment creation form.
     *
     * @param  Doctor  $doctor  The doctor instance provided by route model binding.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchedules(Request $request, Doctor $doctor)
    {
        $date = $request->query('date'); // From JS query parameter
        if (! $date) {
            return response()->json([
                'success' => false,
                'message' => 'Date is required.',
            ]);
        }

        $today = \Carbon\Carbon::today();
        $requestedDate = \Carbon\Carbon::parse($date);
        $daysToLookAhead = 7;

        // Only allow dates from today up to 7 days ahead
        if ($requestedDate->lt($today) || $requestedDate->gt($today->copy()->addDays($daysToLookAhead))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid date. Choose within the next 7 days.',
            ]);
        }

        // Get the day short name (Mon, Tue, etc.)
        $dayShortName = $requestedDate->format('D');

        // Fetch the doctor's schedule for that day
        $schedule = \DB::table('doctor_schedules')
            ->where('doctor_id', $doctor->id)
            ->where('available_day', $dayShortName)
            ->first();

        if (! $schedule) {
            return response()->json([
                'success' => true,
                'schedules' => [], // No slots available
            ]);
        }

        // Get existing booked slots
        $bookedSlots = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $requestedDate->toDateString())
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->get()
            ->map(function ($a) {
                return \Carbon\Carbon::parse($a->start_time)->format('H:i').'-'.\Carbon\Carbon::parse($a->end_time)->format('H:i');
            })->toArray();

        // Generate 30-min slots
        $startTime = \Carbon\Carbon::parse($schedule->start_time);
        $endTime = \Carbon\Carbon::parse($schedule->end_time);
        $slots = [];

        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->format('H:i');
            $slotEnd = $startTime->copy()->addMinutes(30)->format('H:i');
            $slotRange = "{$slotStart}-{$slotEnd}";

            if (! in_array($slotRange, $bookedSlots)) {
                $slots[] = $slotRange;
            }

            $startTime->addMinutes(30);
        }

        return response()->json([
            'success' => true,
            'schedules' => [
                [
                    'available_day' => $requestedDate->toDateString(),
                    'day_name' => $requestedDate->format('l'),
                    'slots' => $slots,
                ],
            ],
        ]);
    }

    /**
     * Store a newly created appointment in storage, requiring a specific time slot.
     */
    public function store(Request $request)
    {
        // 1. Validation for specific date and time slot
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => [
                'required',
                'string',
                // Regex for HH:MM-HH:MM format
                'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]-([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
            ],
            'reason' => 'nullable|string|max:255', // Added reason field from your original code
        ], [
            'time_slot.regex' => 'The selected time slot is invalid.',
        ]);

        $patientId = Auth::id();

        // 2. Parse the time slot
        [$startTime, $endTime] = explode('-', $request->time_slot);

        // 3. CRUCIAL: Conflict Check (Prevents double booking in a race condition)
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['time_slot' => 'This slot was just booked by another patient. Please choose a different time.'])
                ->withInput();
        }

        // 4. Database Save
        try {
            Appointment::create([
                'patient_id' => $patientId,
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'reason' => $request->reason,
                'status' => 'Pending', // Default status for a new appointment
            ]);

            return redirect()->route('patient.appointments.index')
                ->with('success', 'Your appointment has been successfully booked!');

        } catch (\Exception $e) {
            \Log::error('Appointment booking failed: '.$e->getMessage());

            return back()->withErrors(['general' => 'We could not book your appointment due to a server error. Please try again.'])
                ->withInput();
        }
    }
}
