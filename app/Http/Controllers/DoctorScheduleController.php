<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use App\Models\Appointment; // Assuming you have an Appointment model
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DoctorScheduleController extends Controller
{
    /**
     * Fetches and calculates available 30-minute time slots for a specific doctor and date.
     * * @param int $doctorId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchedules(int $doctorId, Request $request)
    {
        // 1. Validate the incoming date
        $request->validate(['date' => 'required|date']);
        $requestedDate = $request->input('date');

        try {
            // Determine the day name (e.g., '2025-10-25' -> 'Sat')
            $dayName = Carbon::parse($requestedDate)->format('D'); // Gets Mon, Tue, Wed, etc.

            // 2. Find the schedule for the doctor on that specific day
            $schedule = DoctorSchedule::where('doctor_id', $doctorId)
                ->where('available_day', $dayName)
                ->first();

            // Prepare the response structure that the frontend JavaScript expects
            $response = [
                'available_day' => $requestedDate,
                'slots' => []
            ];

            if (!$schedule) {
                // Return an empty slots array if no schedule is found
                return response()->json(['schedules' => [$response]]);
            }

            // Convert start and end times to Carbon objects for easy manipulation
            $startTime = Carbon::parse($requestedDate . ' ' . $schedule->start_time);
            $endTime = Carbon::parse($requestedDate . ' ' . $schedule->end_time);

            // 3. Calculate 30-minute slots
            $timeSlots = [];
            $currentSlot = clone $startTime;

            while ($currentSlot->lessThan($endTime)) {
                $slotStart = $currentSlot->format('H:i');
                $slotEnd = $currentSlot->addMinutes(30)->format('H:i');

                // Ensure the end of the slot doesn't exceed the defined end_time
                if ($currentSlot->greaterThanOrEqualTo($endTime) && $slotEnd !== $endTime->format('H:i')) {
                    break;
                }
                
                $timeSlots[] = "{$slotStart}-{$slotEnd}";
            }
            
            // 4. Filter out already booked slots
            
            // Find all existing appointments for this doctor on this day
            $bookedAppointments = Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $requestedDate)
                ->pluck('time_slot') // Assuming 'time_slot' column stores the 'HH:MM-HH:MM' format
                ->toArray();
            
            // Filter the generated slots by removing booked slots
            $availableSlots = array_diff($timeSlots, $bookedAppointments);


            $response['slots'] = array_values($availableSlots); // array_values resets keys after diff
            
            // Return the structure the front-end JS expects (an array of schedules)
            return response()->json(['schedules' => [$response]]);

        } catch (\Exception $e) {
            // Log the error and return a generic server error
            \Log::error("Schedule fetching error: " . $e->getMessage());
            return response()->json([
                'error' => 'Could not fetch schedules due to a server error.'
            ], 500);
        }
    }
}
