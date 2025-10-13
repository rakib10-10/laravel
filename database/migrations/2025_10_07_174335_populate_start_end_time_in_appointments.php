<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        $appointments = DB::table('appointments')->get();

        foreach ($appointments as $appointment) {
            $start = Carbon::parse($appointment->appointment_date)->format('H:i');
            $end = Carbon::parse($appointment->appointment_date)->addMinutes(30)->format('H:i');

            DB::table('appointments')
                ->where('id', $appointment->id)
                ->update([
                    'start_time' => $start,
                    'end_time' => $end,
                ]);
        }
    }

    public function down(): void
    {
        DB::table('appointments')->update([
            'start_time' => null,
            'end_time' => null,
        ]);
    }
};
