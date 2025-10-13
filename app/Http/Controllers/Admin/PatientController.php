<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index()
    {
        $patients = Patient::with('user')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created patient in database.
     */
    public function store(Request $request)
    {
        // 1. Update Validation Rules to include new required fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date', // Assuming date_of_birth should be required
            'gender' => 'required|in:Male,Female,Other', // Add gender validation
            'blood_type' => 'required|string|max:3', // Add blood_type validation
            'address' => 'required|string|max:500', // Assuming address should be required
            'emergency_contact' => 'required|string|max:255', // Add emergency_contact validation
        ]);

        // Create a user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // Default password
            'role' => 'patient',
        ]);

        // 2. Update Patient::create to include new fields
        Patient::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender, // Added
            'blood_type' => $request->blood_type, // Added
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact, // Added
        ]);


        return redirect()->route('admin.patients.index')->with('success', 'Patient added successfully!');
    }

    /**
     * Show the form for editing a patient.
     */
    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update a patient record in database.
     */
    public function update(Request $request, Patient $patient)
    {
        // 3. Update Validation Rules for the update method
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$patient->user_id}",
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other', // Add gender validation
            'blood_type' => 'required|string|max:3', // Add blood_type validation
            'address' => 'required|string|max:500',
            'emergency_contact' => 'required|string|max:255', // Add emergency_contact validation
        ]);

        // Update user info
        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // 4. Update patient info to include new fields
        $patient->update([
            'name' => $request->name, // Added 'name' back to patient update
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender, // Added
            'blood_type' => $request->blood_type, // Added
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact, // Added
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully!');
    }

    /**
     * Remove the patient from database.
     */
    public function destroy(Patient $patient)
    {
        $patient->user()->delete(); // Also deletes the linked user
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully!');
    }

    /**
     * Search patients by name or email (optional)
     */
    public function search(Request $request)
    {
        $q = $request->input('q');
        $patients = Patient::with('user')
            ->whereHas('user', function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            })
            ->paginate(10);

        return view('admin.patients.index', compact('patients'));
    }
}