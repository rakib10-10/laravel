@extends('layouts.patient_home')

@section('content')

<div class="container mx-auto p-4 sm:p-8">
<div class="flex justify-between items-center mb-6">
<h1 class="text-3xl font-bold text-gray-800">My Appointments</h1>
{{-- This button correctly links to the booking form --}}
<a href="{{ route('patient.appointments.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md flex items-center">
<i class="fa-solid fa-plus mr-2"></i> Book New Appointment
</a>
</div>

@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if($appointments->isEmpty())
    <div class="text-center p-10 bg-white rounded-xl shadow-lg">
        <i class="fa-solid fa-calendar-times text-6xl text-gray-400 mb-4"></i>
        <p class="text-gray-600 text-lg">You have no scheduled appointments. Start by booking one!</p>
    </div>
@else
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Slot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $appointment->doctor->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if (strtolower($appointment->status) == 'pending' && (empty($appointment->start_time) || empty($appointment->end_time)))
                                <span class="text-indigo-600 font-semibold">TBA - Awaiting Confirmation</span>
                            @else
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusLower = strtolower($appointment->status);
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ][$statusLower] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full capitalize {{ $statusClass }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex space-x-2 justify-end items-center">
                            
                            {{-- View Details Link (Corrected to use 'show' route) --}}
                            <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-900 text-xs font-bold transition duration-150">
                                View Details
                            </a>

                            {{-- Cancel Form (using DELETE method for RESTful API) --}}
                            @if ($statusLower == 'pending')
                                <form action="{{ route('patient.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold transition duration-150 ml-2">
                                        Cancel Request
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="p-4 bg-white border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
    </div>
@endif

</div>
@endsection