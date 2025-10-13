<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds to schedule all doctors (IDs 71 through 141).
     */
    public function run(): void
    {
        // Define the list of Doctor IDs from the provided dataset
        $doctorIds = range(71, 141);

        // Define a variety of schedule patterns to cycle through
        $schedulePatterns = [
            // Pattern 1: Standard Full-Time (Mon-Fri)
            ['days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'], 'start' => '09:00:00', 'end' => '17:00:00'],

            // Pattern 2: Part-Time Morning (Mon/Wed/Fri)
            ['days' => ['Mon', 'Wed', 'Fri'], 'start' => '10:00:00', 'end' => '15:00:00'],

            // Pattern 3: Late Shift (Tue/Thu)
            ['days' => ['Tue', 'Thu'], 'start' => '12:00:00', 'end' => '20:00:00'],

            // Pattern 4: Specialist Shift (Mon-Thu, No Friday)
            ['days' => ['Mon', 'Tue', 'Wed', 'Thu'], 'start' => '08:00:00', 'end' => '16:00:00'],
        ];

        $schedules = [];
        $patternIndex = 0;
        $now = now();

        // Loop through all 71 doctor IDs and assign a schedule pattern
        foreach ($doctorIds as $doctorId) {
            $pattern = $schedulePatterns[$patternIndex % count($schedulePatterns)];

            foreach ($pattern['days'] as $day) {
                $schedules[] = [
                    'doctor_id' => $doctorId,
                    'available_day' => $day,
                    'start_time' => $pattern['start'],
                    'end_time' => $pattern['end'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            $patternIndex++;
        }

        // Insert all generated schedules into the database in a single query
        DB::table('doctor_schedules')->insert($schedules);
    }
}
