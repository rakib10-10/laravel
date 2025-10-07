<?php
// Only use the namespace corresponding to the file's location (app/Http/Controllers)
namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Search patients by name (from user table) or other fields.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]); // Return empty array if no query
        }

        $patients = Patient::with('user')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get()
            ->map(function($patient) {
                return [
                    'id' => $patient->id,
                    'name' => $patient->user->name,
                    'email' => $patient->user->email,
                    'phone' => $patient->phone,
                    'date_of_birth' => $patient->date_of_birth,
                ];
            });

        return response()->json($patients);
    }
}
