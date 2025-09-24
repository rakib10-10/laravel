@extends('admin.home')

@section('content')
<div class="container py-5">

    {{-- Page Title --}}
    <h2 class="mb-4 fw-bold text-gradient text-center animate__animated animate__fadeInDown">
        🔎 Search Patient
    </h2>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-5 animate__animated animate__fadeInUp">
        <div class="input-group search-box">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Type patient name..." required>
            <button type="submit" class="btn btn-gradient fw-semibold">Search</button>
        </div>
    </form>

    {{-- Show Search Results --}}
    @if(isset($patients) && count($patients))
        <div class="list-group mb-5 animate__animated animate__fadeIn card-style">
            @foreach($patients as $p)
                <a href="{{ route('admin.reports.index', ['patient_id' => $p->id]) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center patient-item">
                    <div>
                        <strong>{{ $p->name }}</strong> 
                        <small class="text-muted">({{ $p->gender }}, {{ $p->date_of_birth }})</small>
                    </div>
                    <span class="badge bg-gradient rounded-pill shadow-sm">Select</span>
                </a>
            @endforeach
        </div>
    @elseif(request('q'))
        <div class="alert alert-warning text-center animate__animated animate__fadeIn">
            No results found for "<strong>{{ request('q') }}</strong>"
        </div>
    @endif

    {{-- Selected Patient --}}
    @if(isset($selectedPatient) && $selectedPatient)
    <div class="card mb-5 card-style animate__animated animate__fadeInUp">
        <div class="card-header bg-gradient text-white shadow-sm">
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
{{-- Previous Reports --}}
@if(isset($previousReports) && $previousReports->count())
<div class="card mb-5 card-style animate__animated animate__fadeInUp">
    <div class="card-header bg-info-gradient text-white shadow-sm">
        <h4 class="mb-0">📋 Previous Reports</h4>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle table-modern">
            <thead>
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
               @foreach($previousReports as $i => $report) <tr> 
                <td>{{ $i+1 }}</td>
                 <td>{{ \Carbon\Carbon::parse($report->visit_date)->format('d M Y, h:i A') }}</td>
                  <td>{{ $report->doctor->name ?? 'Unknown' }}</td>
                   <td>{{ $report->diagnosis ?? '-' }}</td> <td> @if(!empty($report->medicines)) 
                    <table class="table table-sm table-bordered"> <thead class="table-light">
                         <tr> 
                        <th>Medicine</th> 
                        <th>Dosage</th>
                         <th>Notes</th>
                         </tr>
                         </thead>
                <tbody> 
                    @php $medicines = $report->medicines ?? []; // ensure it's at least an array @endphp @if(is_array($medicines) || $medicines instanceof \Illuminate\Support\Collection) @foreach($medicines as $med) <tr> <td>{{ $med['medicine_name'] ?? 'N/A' }}</td> <td>{{ $med['dosage'] ?? 'N/A' }}</td> <td>{{ $med['notes'] ?? 'N/A' }}</td> </tr> @endforeach @endif </tbody> </table> @endif </td>
                    <td>{{ $report->additional_notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(session('success'))
    <div class="alert alert-success animate__animated animate__fadeIn">
        {{ session('success') }}
    </div>
@endif


{{-- Report Form --}}
<div class="card card-style animate__animated animate__fadeInUp">
    <div class="card-header bg-success-gradient text-white shadow-sm">
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
                <input type="datetime-local" name="visit_date" class="form-control input-modern" required>
            </div>

            {{-- Diagnosis --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Diagnosis</label>
                <textarea name="diagnosis" class="form-control input-modern" rows="4" placeholder="Enter diagnosis..."></textarea>
            </div>

            {{-- Medicines --}}
            <div class="mb-3">
                <h5 class="fw-semibold">💊 Medicines (Drag & Drop)</h5>

                <div class="row">
                <div class="col-md-6">
                    <h6>Available Medicines</h6>
                    <ul id="availableMedicines" class="list-group p-2 border rounded bg-light" style="min-height:200px;">
                        @foreach($allMedicines as $med)
                            <li class="list-group-item draggable" draggable="true" data-name="{{ $med->name }}">
                                {{ $med->name }} ({{ $med->strength }})
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Selected Medicines</h6>
                    <div id="medicineWrapper" class="p-2 border rounded bg-white" style="min-height:200px;">
                        <p class="text-muted">Drag medicines here...</p>
                    </div>
                </div>
            </div>
            </div>

            {{-- Tests --}}
            <div class="mb-3">
                <h5 class="fw-semibold">🧪 Tests</h5>
                <div id="testWrapper">
                    <div class="row g-2 mb-2 test-item">
                        <div class="col-md-10">
                            <input type="text" name="tests[]" class="form-control input-modern" placeholder="Test Name">
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm removeTest">✖</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="addTest" class="btn btn-outline-gradient btn-sm mt-2">➕ Add Test</button>
            </div>

            {{-- Additional Notes --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Additional Notes</label>
                <textarea name="additional_notes" class="form-control input-modern" rows="3" placeholder="Any extra notes..."></textarea>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-gradient px-4 fw-semibold shadow-sm">
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
    .text-gradient {
        background: linear-gradient(90deg, #0072ff, #00c6ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .btn-gradient {
        background: linear-gradient(90deg, #0072ff, #00c6ff);
        border: none;
        color: #fff !important;
        transition: 0.3s;
    }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #0052cc, #0099cc);
        transform: scale(1.05);
    }
    .btn-outline-gradient {
        border: 2px solid #00c6ff;
        color: #00c6ff;
        transition: 0.3s;
    }
    .btn-outline-gradient:hover {
        background: #00c6ff;
        color: #fff;
    }
    .bg-gradient {
        background: linear-gradient(90deg, #0072ff, #00c6ff);
    }
    .bg-info-gradient {
        background: linear-gradient(90deg, #17a2b8, #00d4ff);
    }
    .bg-success-gradient {
        background: linear-gradient(90deg, #28a745, #00c851);
    }
    .card-style {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .input-modern {
        border-radius: 0.75rem;
        border: 1px solid #e0e0e0;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    }
    .search-box input {
        border-radius: 0.75rem 0 0 0.75rem;
    }
    .search-box .btn {
        border-radius: 0 0.75rem 0.75rem 0;
    }
    .patient-item {
        transition: all 0.2s;
    }
    .patient-item:hover {
        background: #f1faff;
        transform: translateX(4px);
    }
    .table-modern thead {
        background: #f8f9fa;
        font-weight: bold;
    }
</style>

{{-- Animation Library --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- JS for Dynamic Fields --}}
<script>
 const available = document.getElementById('availableMedicines');
const selected = document.getElementById('medicineWrapper');

// Make items draggable
document.querySelectorAll('.draggable').forEach(item => {
    item.addEventListener('dragstart', e => {
        e.dataTransfer.setData('text/plain', e.target.dataset.name);
    });
});

// Allow drop
selected.addEventListener('dragover', e => e.preventDefault());

// Drop handler
selected.addEventListener('drop', e => {
    e.preventDefault();
    const medName = e.dataTransfer.getData('text/plain');

    const div = document.createElement('div');
    div.className = "row g-2 mb-2 medicine-item";
    div.innerHTML = `
        <div class="col-md-4"><input type="text" name="medicines[]" value="${medName}" class="form-control input-modern" readonly></div>
        <div class="col-md-3"><input type="text" name="dosages[]" class="form-control input-modern" placeholder="Dosage"></div>
        <div class="col-md-4"><input type="text" name="notes[]" class="form-control input-modern" placeholder="Notes"></div>
        <div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-danger btn-sm removeMedicine">✖</button></div>
    `;
    selected.appendChild(div);
});

// Remove medicine
selected.addEventListener('click', e => {
    if(e.target.classList.contains('removeMedicine')) {
        e.target.closest('.medicine-item').remove();
    }
});

</script>
@endsection
