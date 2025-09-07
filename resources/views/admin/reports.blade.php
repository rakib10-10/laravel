@extends('admin.home')

@section('reports')
<div class="container py-5">

    {{-- Page Title --}}
    <h2 class="mb-4 fw-bold text-primary text-center animate__animated animate__fadeInDown">
        🔎 Search Patient
    </h2>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-5 animate__animated animate__fadeInUp">
        <div class="input-group shadow-sm rounded overflow-hidden">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control border-0" placeholder="Type patient name..." required>
            <button type="submit" class="btn btn-primary px-4 fw-semibold">Search</button>
        </div>
    </form>

    {{-- Show Search Results --}}
    @if(isset($patients) && count($patients))
        <div class="list-group mb-5 shadow-sm animate__animated animate__fadeIn">
            @foreach($patients as $p)
                <a href="{{ route('admin.reports.index', ['patient_id' => $p->id]) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center hover-card">
                    <div>
                        <strong>{{ $p->name }}</strong> 
                        <small class="text-muted">({{ $p->gender }}, {{ $p->date_of_birth }})</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">Select</span>
                </a>
            @endforeach
        </div>
    @elseif(request('q'))
        <div class="alert alert-warning mb-5 animate__animated animate__fadeIn">
            No results found for "<strong>{{ request('q') }}</strong>"
        </div>
    @endif

    {{-- Selected Patient --}}
    @if(isset($selectedPatient) && $selectedPatient)
    <div class="card mb-5 shadow border-0 animate__animated animate__fadeInUp hover-card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">👤 Selected Patient</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6"><strong>Name:</strong> {{ $selectedPatient->name }}</div>
                <div class="col-md-6"><strong>DOB:</strong> {{ $selectedPatient->date_of_birth }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Gender:</strong> {{ $selectedPatient->gender }}</div>
                <div class="col-md-6"><strong>Blood Type:</strong> {{ $selectedPatient->blood_type ?? 'N/A' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Address:</strong> {{ $selectedPatient->address ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Emergency Contact:</strong> {{ $selectedPatient->emergency_contact ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    {{-- Previous Reports --}}
@if(isset($previousReports) && $previousReports->count())
<div class="card mb-5 shadow border-0 animate__animated animate__fadeInUp hover-card">
    <div class="card-header bg-info text-white">
        <h4 class="mb-0">📋 Previous Reports</h4>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Visit Date</th>
                    <th>Doctor</th>
                    <th>Diagnosis</th>
                    <th>Medicines</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($previousReports as $i => $report)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->visit_date)->format('d M Y, h:i A') }}</td>
                    <td>{{ $report->doctor->name ?? 'Unknown' }}</td>
                    <td>{{ $report->diagnosis ?? '-' }}</td>
                    <td>
                        

                        @if(!empty($report->medicines))
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $medicines = $report->medicines ?? []; // ensure it's at least an array
                                    @endphp
                                    @if(is_array($medicines) || $medicines instanceof \Illuminate\Support\Collection)
                                    @foreach($medicines as $med)
                                        <tr>
                                            <td>{{ $med['medicine_name'] ?? 'N/A' }}</td>
                                            <td>{{ $med['dosage'] ?? 'N/A' }}</td>
                                            <td>{{ $med['notes'] ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        @endif

                    </td>
                    <td>{{ $report->additional_notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif


    {{-- Report Form --}}
    <div class="card shadow border-0 animate__animated animate__fadeInUp hover-card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">📝 Create Report</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.reports.store') }}">
                @csrf 
                <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">
                <input type="hidden" name="doctor_id" value="{{ auth()->user()->doctor->id ?? null }}">

                {{-- Visit Date --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Visit Date</label>
                    <input type="datetime-local" name="visit_date" class="form-control shadow-sm" required>
                </div>

                {{-- Diagnosis --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control shadow-sm" rows="4" placeholder="Enter diagnosis..."></textarea>
                </div>

                {{-- Medicines --}}
                <div class="mb-3">
                    <h5 class="fw-semibold">💊 Medicines</h5>
                    <div id="medicineWrapper">
                        <div class="row g-2 mb-2 medicine-item">
                            <div class="col-md-4">
                                <input type="text" name="medicines[]" class="form-control" placeholder="Medicine Name">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="dosages[]" class="form-control" placeholder="Dosage">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="notes[]" class="form-control" placeholder="Notes">
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm removeMedicine">✖</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addMedicine" class="btn btn-outline-primary btn-sm mt-2">➕ Add Medicine</button>
                </div>

                {{-- Tests --}}
                <div class="mb-3">
                    <h5 class="fw-semibold">🧪 Tests</h5>
                    <div id="testWrapper">
                        <div class="row g-2 mb-2 test-item">
                            <div class="col-md-10">
                                <input type="text" name="tests[]" class="form-control" placeholder="Test Name">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm removeTest">✖</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addTest" class="btn btn-outline-primary btn-sm mt-2">➕ Add Test</button>
                </div>

                {{-- Additional Notes --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Additional Notes</label>
                    <textarea name="additional_notes" class="form-control shadow-sm" rows="3" placeholder="Any extra notes..."></textarea>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm">
                        💾 Save Report
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

{{-- Custom Styles --}}
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
    }
    .list-group-item {
        transition: all 0.2s ease-in-out;
    }
    .list-group-item:hover {
        background: #f8f9fa;
        transform: scale(1.02);
    }
    textarea, input {
        border-radius: 0.5rem !important;
    }
</style>

{{-- Animation Library --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- JS for Dynamic Fields --}}
<script>
    document.getElementById('addMedicine').addEventListener('click', function() {
        let wrapper = document.getElementById('medicineWrapper');
        let newField = document.createElement('div');
        newField.classList.add('row','g-2','mb-2','medicine-item');
        newField.innerHTML = `
            <div class="col-md-4"><input type="text" name="medicines[]" class="form-control" placeholder="Medicine Name"></div>
            <div class="col-md-3"><input type="text" name="dosages[]" class="form-control" placeholder="Dosage"></div>
            <div class="col-md-4"><input type="text" name="notes[]" class="form-control" placeholder="Notes"></div>
            <div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-danger btn-sm removeMedicine">✖</button></div>
        `;
        wrapper.appendChild(newField);
    });

    document.getElementById('medicineWrapper').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeMedicine')) {
            e.target.closest('.medicine-item').remove();
        }
    });

    document.getElementById('addTest').addEventListener('click', function() {
        let wrapper = document.getElementById('testWrapper');
        let newField = document.createElement('div');
        newField.classList.add('row','g-2','mb-2','test-item');
        newField.innerHTML = `
            <div class="col-md-10"><input type="text" name="tests[]" class="form-control" placeholder="Test Name"></div>
            <div class="col-md-2 d-flex align-items-center"><button type="button" class="btn btn-danger btn-sm removeTest">✖</button></div>
        `;
        wrapper.appendChild(newField);
    });

    document.getElementById('testWrapper').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeTest')) {
            e.target.closest('.test-item').remove();
        }
    });
</script>
@endsection
