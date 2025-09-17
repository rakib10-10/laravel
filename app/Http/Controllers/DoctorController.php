<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        // 1. Validate the form data, including the image.
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Added image validation
        ]);
        
        // 2. Handle image upload and save the filename.
        $imageName = null;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        // 3. Create the User record first to get a user ID.
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make('12345678'),
            'role' => 'doctor',
        ]);

        // 4. Create the Doctor record using the new user's ID.
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
            'profile_image' => $imageName, // Save the image name
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        // 1. Validate the form data.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($doctor->user->id)],
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Added image validation
        ]);

        // 2. Handle image update and deletion of old image.
        if ($request->hasFile('profile_image')) {
            // Delete the old image if it exists
            if ($doctor->profile_image && File::exists(public_path('images/' . $doctor->profile_image))) {
                File::delete(public_path('images/' . $doctor->profile_image));
            }

            $image = $request->file('profile_image');
            $imageName = time() . '.' . Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validatedData['profile_image'] = $imageName;
        }

        // 3. Update the user record
        $doctor->user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // 4. Update the doctor record
        $doctor->update($validatedData);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // Delete the associated user first to avoid integrity issues
        if ($doctor->user) {
            $doctor->user->delete();
        }

        // Delete the profile image from storage
        if ($doctor->profile_image) {
            File::delete(public_path('images/' . $doctor->profile_image));
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor and associated user account deleted successfully!');
    }
}