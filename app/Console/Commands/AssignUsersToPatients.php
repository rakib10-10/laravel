<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Patient;

class AssignUsersToPatients extends Command
{
    protected $signature = 'patients:assign-users';
    protected $description = 'Assign user_id to patients based on matching names';

    public function handle()
    {
        $patients = Patient::all();
        $assignedCount = 0;

        foreach ($patients as $patient) {
            // Remove common prefixes and suffixes and trim spaces
            $cleanName = preg_replace(
                '/^(Dr\.|Prof\.|Mrs\.|Ms\.|Mr\.)\s+|\s+(MD|PhD|DDS|DVM|IV|Jr\.|II|III|IV)$/i',
                '',
                $patient->name
            );
            $cleanName = trim($cleanName);

            // Find user by name (case-insensitive, partial match)
            $user = User::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($cleanName) . '%'])->first();

            if ($user) {
                $patient->user_id = $user->id;
                $patient->save();
                $assignedCount++;
                $this->info("Assigned User ID {$user->id} to Patient '{$patient->name}'");
            } else {
                $this->warn("No user found for patient: {$patient->name}");
            }
        }

        $this->info("Done! Total patients assigned: {$assignedCount}");
    }
}
