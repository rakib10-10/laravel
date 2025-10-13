<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Slot;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class SlotSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();
        $daysToGenerate = 30; // next 30 days

        foreach ($doctors as $doctor) {
            for ($i = 0; $i < $daysToGenerate; $i++) {
                $date = Carbon::now()->addDays($i)->toDateString();

                // Skip if slots already exist for this doctor & date
                if (Slot::where('doctor_id', $doctor->id)->where('slot_date', $date)->exists()) {
                    continue;
                }

                // Create slots from 10:00 AM to 5:00 PM (30 min interval)
                $startTime = Carbon::createFromTime(10, 0, 0);
                $endTime   = Carbon::createFromTime(17, 0, 0);
                $interval  = CarbonInterval::minutes(30);

                while ($startTime->lt($endTime)) {
                    $slotEnd = $startTime->copy()->add($interval);

                    Slot::create([
                        'doctor_id' => $doctor->id,
                        'slot_date' => $date,
                        'start_time' => $startTime->format('H:i:s'),
                        'end_time' => $slotEnd->format('H:i:s'),
                        'is_booked' => 0,
                    ]);

                    $startTime->add($interval);
                }
            }
        }

        $this->command->info('Slots created for all doctors for the next 30 days!');
    }
}
