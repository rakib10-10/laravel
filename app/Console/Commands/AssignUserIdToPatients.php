<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Patient;

class AssignUserIdToPatients extends Command
{
    protected $signature = 'patients:assign-user';
    protected $description = 'Assign user_id to patients based on fuzzy name matching';

    public function handle()
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            // Clean patient name: remove prefixes/suffixes and trim spaces
            $cleanName = preg_replace(
                '/^(Dr\.|Prof\.|Mrs\.|Ms\.|Mr\.)\s+|\s+(MD|PhD|DDS|DVM|IV|Jr\.|II|III|IV)$/i',
                '',
                $patient->name
            );
            $cleanName = trim($cleanName);

            // Split name into words for fuzzy matching
            $words = explode(' ', $cleanName);

            // Build query to match all words in user name
            $query = User::query();
            foreach ($words as $word) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($word) . '%']);
            }

            $user = $query->first();

            if ($user) {
                $patient->user_id = $user->id;
                $patient->save();
                $this->info("✅ Assigned user {$user->id} to patient {$patient->name}");
            } else {
                $this->warn("❌ No user found for patient: {$patient->name}");
            }
        }

        $this->info('✅ Done assigning users to patients.');
    }
}
