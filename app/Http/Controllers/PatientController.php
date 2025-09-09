<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]); // return empty array if no query
        }

        $patients = Patient::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'gender', 'date_of_birth')
            ->limit(10)
            ->get();

        return response()->json($patients);
    }
}
