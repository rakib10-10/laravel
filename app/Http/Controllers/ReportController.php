<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Report;
use App\Models\ReportMedicine;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the reports page and optionally search/select a patient
     */
    public function index(Request $request)

    {
        $allMedicines =\App\Models\Medicine::all();
        $q = $request->get('q');
        $patientId = $request->get('patient_id');

        $patients = [];
        $selectedPatient = null;
        $previousReports = collect(); // empty by default

        if (!empty($q)) {
            $patients = Patient::where('name', 'like', "%{$q}%")
                ->limit(10)
                ->get();
        }

        if (!empty($patientId)) {
            $selectedPatient = Patient::find($patientId);

            if ($selectedPatient) {
                $previousReports = Report::with('doctor')
                    ->where('patient_id', $selectedPatient->id)
                    ->latest('visit_date')
                    ->get();
            }
        }

        return view('admin.reports', compact('patients', 'selectedPatient', 'previousReports', 'allMedicines'));
    }
        



    /**
     * Store a new report
     */
    public function store(Request $request)
    

{
    $data = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'nullable|exists:users,id',
        'visit_date' => 'required',
        'diagnosis' => 'nullable|string',
        'additional_notes' => 'nullable|string',
        'medicines.*' => 'nullable|string',
        'dosages.*' => 'nullable|string',
        'notes.*' => 'nullable|string',
        'tests.*' => 'nullable|string',
    ]);

    // $doctor = Doctor::inRandomOrder()->first();

    // Convert visit_date to proper format if needed
    $data['visit_date'] = str_replace('T', ' ', $data['visit_date']);

    // Build medicines array
    $medicines = [];
    if(!empty($request->medicines)) {
        foreach($request->medicines as $i => $name) {
            if($name) {
                $medicines[] = [
                    'medicine_name' => $name,
                    'dosage' => $request->dosages[$i] ?? '',
                    'notes' => $request->notes[$i] ?? '',
                ];
            }
        }
    }

    // Build tests array
   $tests = $request->tests ?? [];

    // Save report
    $report = report::create([
    'patient_id' => $request->patient_id,
    'doctor_id' =>16, // $doctor->id, // Assign a random doctor for now
    'visit_date' => str_replace('T', ' ', $request->visit_date),
    'diagnosis' => $request->diagnosis,
    'additional_notes' => $request->additional_notes,
    'medicines' => $medicines,  // array will be converted to JSON
    'tests' => $tests,          // array will be converted to JSON
]);

    return redirect()->back()->with('success', 'Report saved successfully!');
}

}
