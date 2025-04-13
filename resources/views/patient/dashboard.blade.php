@extends('layouts.patient')

@section('title', 'Dashboard')
@section('page-title', 'Patient Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Welcome Card -->
    <div class="col-span-1 md:col-span-2 bg-white rounded-xl shadow-card p-6 card">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Welcome back, {{ $user->first_name }}!</h2>
                <p class="text-gray-600 mt-1">Here's a summary of your health status</p>
            </div>
            <div class="bg-accent bg-opacity-10 rounded-lg p-3">
                <i class="fas fa-user-md text-accent text-xl"></i>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-lg p-4 flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-blue-600">Upcoming Appointment</p>
                    <p class="font-semibold">
                        @if($appointments->count() > 0)
                            {{ $appointments->first()->appointment_date ?? 'None' }}
                        @else
                            None
                        @endif
                    </p>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <i class="fas fa-prescription-bottle-alt text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-green-600">Active Prescriptions</p>
                    <p class="font-semibold">{{ $latestPrescriptions->count() }}</p>
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 flex items-center">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <i class="fas fa-file-medical-alt text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-purple-600">Medical Records</p>
                    <p class="font-semibold">{{ $latestDiseases->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vital Statistics Card -->
    <div class="col-span-1 bg-white rounded-xl shadow-card p-6 card">
        <h3 class="font-semibold text-lg text-gray-800 mb-4">Your Vital Signs</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <i class="fas fa-heartbeat text-red-500"></i>
                    </div>
                    <span class="text-gray-700">Heart Rate</span>
                </div>
                <span class="font-semibold">{{ isset($latestHeartRate['value']) ? $latestHeartRate['value'] : 'N/A' }} bpm</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-tint text-blue-500"></i>
                    </div>
                    <span class="text-gray-700">Blood Pressure</span>
                </div>
                <span class="font-semibold">{{ isset($latestBloodPressure['systolic']) && isset($latestBloodPressure['diastolic']) ? $latestBloodPressure['systolic'].'/'.$latestBloodPressure['diastolic'] : 'N/A' }} mmHg</span>
            </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 rounded-full p-2 mr-3">
                            <i class="fas fa-vial text-yellow-500"></i>
                        </div>
                        <span class="text-gray-700">Blood Sugar</span>
                    </div>
                    <span class="font-semibold">{{ isset($latestBloodSugar['value']) ? $latestBloodSugar['value'] : 'N/A' }} mg/dL</span>
                </div>
            <a href="{{ route('patient.healthMetrics') }}" class="mt-4 text-accent hover:text-accentHover text-sm flex items-center">
                <span>View health history</span>
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-xl shadow-card p-6 card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-lg text-gray-800">Upcoming Appointments</h3>
            <a href="{{ route('patient.appointments') }}" class="text-accent hover:text-accentHover text-sm">View All</a>
        </div>
        @if($appointments->count() > 0)
            <div class="space-y-4">
                @foreach($appointments as $appointment)
                <div class="border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <i class="fas fa-user-md text-blue-500"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium">Dr. {{ $appointment->doctor->first()->user->first_name }} {{ $appointment->doctor->first()->user->last_name }}</h4>
                            <p class="text-sm text-gray-600">{{ $appointment->appointment_date }}</p>
                            <div class="flex items-center mt-2">
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                    {{ $appointment->status }}
                                </span>
                                <span class="ml-2 text-sm text-gray-500">{{ $appointment->reason }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                <i class="fas fa-calendar-times text-4xl mb-3"></i>
                <p>No upcoming appointments</p>
                <a href="{{ route('patient.appointments') }}" class="mt-2 inline-block bg-accent text-white px-4 py-2 rounded-lg text-sm">Book an Appointment</a>
            </div>
        @endif
    </div>

    <!-- Recent Prescriptions -->
    <div class="bg-white rounded-xl shadow-card p-6 card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-lg text-gray-800">Recent Prescriptions</h3>
            <a href="{{ route('patient.prescription') }}" class="text-accent hover:text-accentHover text-sm">View All</a>
        </div>
        @if($latestPrescriptions->count() > 0)
            <div class="space-y-4">
                @foreach($latestPrescriptions as $prescription)
                <div class="border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                    <div class="flex items-start">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <i class="fas fa-prescription text-green-500"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium">{{ $prescription->title }}</h4>
                            <p class="text-sm text-gray-600">Prescribed on {{ date('M d, Y', strtotime($prescription->created_at)) }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">By Dr. {{ $prescription->doctor->user->first_name }} {{ $prescription->doctor->user->last_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                <i class="fas fa-prescription-bottle text-4xl mb-3"></i>
                <p>No prescriptions available</p>
            </div>
        @endif
    </div>
</div>

<!-- Recent Medical Records -->
<div class="bg-white rounded-xl shadow-card p-6 card mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-lg text-gray-800">Recent Medical Records</h3>
    </div>
    @if($latestDiseases->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Diagnosed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($latestDiseases as $disease)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $disease->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ date('M d, Y', strtotime($disease->created_at)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Dr. {{ $disease->doctors->first()->user->first_name }} {{ $disease->doctors->first()->user->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($disease->status == 'Active') bg-red-100 text-red-800
                                @elseif($disease->status == 'Recovered') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $disease->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-6 text-gray-500">
            <i class="fas fa-notes-medical text-4xl mb-3"></i>
            <p>No medical records available</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Any dashboard-specific JavaScript can go here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Patient dashboard loaded');
    });
</script>
@endsection