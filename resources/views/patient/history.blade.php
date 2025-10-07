@extends('layouts.patient_home')

@section('content')
<div class="container">
    <h1>My Medical History</h1>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Doctor</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>2025-09-01</td>
                <td>Dr. Rakib Ahmed</td>
                <td>Common Cold</td>
                <td>Paracetamol 500mg</td>
                <td>Rest and hydration recommended</td>
            </tr>
            <tr>
                <td>2</td>
                <td>2025-08-15</td>
                <td>Dr. Shihab Khan</td>
                <td>Back Pain</td>
                <td>Ibuprofen 200mg</td>
                <td>Physiotherapy advised</td>
            </tr>
            <tr>
                <td>3</td>
                <td>2025-07-20</td>
                <td>Dr. Efaz Hossain</td>
                <td>Fever</td>
                <td>Acetaminophen 500mg</td>
                <td>Monitor temperature, stay hydrated</td>
            </tr>
            <tr>
                <td>4</td>
                <td>2025-06-10</td>
                <td>Dr. Rakib Ahmed</td>
                <td>Allergy</td>
                <td>Antihistamine 10mg</td>
                <td>Avoid allergens, follow-up in 1 week</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
