@extends('admin.home')

@section('content')
<h2 class="page-title">Manage Patients</h2>

<a href="{{ route('admin.patients.create') }}" class="btn btn-success mb-3">Add New Patient</a>

<form method="GET" action="{{ route('admin.patients.search') }}" class="mb-3">
    <input type="text" name="q" placeholder="Search patients..." class="form-control" value="{{ request('q') }}">
</form>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>DOB</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($patients as $patient)
        <tr>
            <td>{{ $patient->user->name }}</td>
            <td>{{ $patient->user->email }}</td>
            <td>{{ $patient->phone }}</td>
            <td>{{ $patient->date_of_birth }}</td>
            <td>
                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this patient?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">No patients found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $patients->links() }}
@endsection
