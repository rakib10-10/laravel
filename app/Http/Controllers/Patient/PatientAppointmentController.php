<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment; // Assuming this model exists
use App\Models\Doctor;      // Assuming this model exists

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
     * @param Request $request
     * @param Doctor $doctor The doctor instance provided by route model binding.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchedules(Request $request, Doctor $doctor)
    {
        $schedulesData = [];
        $today = Carbon::today();
        $daysToLookAhead = 7;

        // 1. Fetch the doctor's recurring schedules (indexed by short day name: Mon, Tue, etc.)
        $recurringSchedules = DB::table('doctor_schedules')
                                ->where('doctor_id', $doctor->id)
                                ->get()
                                ->keyBy(fn($schedule) => substr($schedule->available_day, 0, 3));

        // 2. Fetch all existing bookings for the next 7 days for this doctor
        $bookedSlots = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->whereBetween('appointment_date', [
                $today->toDateString(),
                $today->copy()->addDays($daysToLookAhead)->toDateString()
            ])
            ->get()
            ->map(function ($booking) {
                // Map to a string like '2025-10-06|09:00-09:30' for easy checking
                $timeRange = Carbon::parse($booking->start_time)->format('H:i') . '-' . Carbon::parse($booking->end_time)->format('H:i');
                return $booking->appointment_date . '|' . $timeRange;
            })->toArray();

        // 3. Iterate through the next 7 days to generate actual available slots
        for ($i = 0; $i < $daysToLookAhead; $i++) {
            $date = $today->copy()->addDays($i);
            $dayShortName = $date->format('D');
            $dayFullName = $date->format('l');
            $fullDateString = $date->toDateString();

            if (isset($recurringSchedules[$dayShortName])) {
                $schedule = $recurringSchedules[$dayShortName];
                $slots = [];

                $startTime = Carbon::parse($schedule->start_time);
                $endTime = Carbon::parse($schedule->end_time);

                // Handle today's schedule: skip slots already past
                if ($i === 0) {
                    $now = Carbon::now();
                    if ($now->greaterThanOrEqualTo($endTime)) {
                         continue;
                    }
                    if ($now->greaterThan($startTime)) {
                        $startTime = $now->ceilMinute(30);
                    }
                }

                // Generate 30-minute slots
                while ($startTime->lessThan($endTime)) {
                    $slotStart = $startTime->format('H:i');
                    $slotEnd = $startTime->copy()->addMinutes(30)->format('H:i');
                    $slotTimeRange = "{$slotStart}-{$slotEnd}";

                    // The key used for checking against bookings
                    $slotKey = $fullDateString . '|' . $slotTimeRange;

                    // Only add the slot if it is NOT in the bookedSlots array
                    if (!in_array($slotKey, $bookedSlots)) {
                        $slots[] = $slotTimeRange;
                    }

                    $startTime = Carbon::parse($slotEnd);
                }

                if (!empty($slots)) {
                    $schedulesData[] = [
                        'available_day' => $fullDateString,
                        'day_name' => $dayFullName,
                        'slots' => $slots,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'doctor_id' => $doctor->id,
            'schedules' => $schedulesData,
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
            \Log::error('Appointment booking failed: ' . $e->getMessage());

            return back()->withErrors(['general' => 'We could not book your appointment due to a server error. Please try again.'])
                         ->withInput();
        }
    }
}
