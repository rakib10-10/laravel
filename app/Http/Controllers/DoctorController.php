<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the form data, matching the database schema.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:3',
            'specialist' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:255',
            'date_of_joining' => 'nullable|date',
            'work_experience' => 'nullable|integer',
        ]);

        // 2. Create the User record first to get a user ID.
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make('12345678'),
            'role' => 'doctor',
        ]);

        // 3. Create the Doctor record using the new user's ID.
        Doctor::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'address' => $validatedData['address'],
            'country' => $validatedData['country'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'blood_group' => $validatedData['blood_group'],
            'specialist' => $validatedData['specialist'],
            'specialization' => $validatedData['specialization'],
            'designation' => $validatedData['designation'],
            'department' => $validatedData['department'],
            'license_number' => $validatedData['license_number'],
            'date_of_joining' => $validatedData['date_of_joining'],
            'work_experience' => $validatedData['work_experience'],
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully!');
    }

    // ... (rest of the controller code)
}