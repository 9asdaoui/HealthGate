@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Dashboard Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>
        <div class="text-sm text-gray-400">
            <span>Welcome back, {{ $user->name }}</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Patients Card -->
        <div class="stat-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Patients</p>
                    <h3 class="text-2xl font-bold text-white">{{ \App\Models\Patient::count() }}</h3>
                </div>
                <div class="bg-teal-900 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-user-injured text-teal-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Doctors Card -->
        <div class="stat-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Doctors</p>
                    <h3 class="text-2xl font-bold text-white">{{ \App\Models\Doctor::count() }}</h3>
                </div>
                <div class="bg-blue-900 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-user-md text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Appointments Card -->
        <div class="stat-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">All Appointments</p>
                    <h3 class="text-2xl font-bold text-white">{{ \App\Models\Appointment::count() }}</h3>
                </div>
                <div class="bg-purple-900 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-calendar-check text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Departments Card -->
        <div class="stat-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Departments</p>
                    <h3 class="text-2xl font-bold text-white">{{ \App\Models\Department::count() }}</h3>
                </div>
                <div class="bg-yellow-900 bg-opacity-30 p-3 rounded-full">
                    <i class="fas fa-hospital text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Appointments Chart -->
        <div class="bg-secondary p-6 rounded-xl shadow-lg border border-borderColor">
            <h3 class="text-lg font-semibold mb-4 text-white">Appointment Status Overview</h3>
            <div class="h-64">
                <canvas id="appointmentChart"></canvas>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="bg-secondary p-6 rounded-xl shadow-lg border border-borderColor">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Recent Appointments</h3>
                <a href="{{ route('admin.dashboard') }}" class="text-teal-500 text-sm hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Doctor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach(\App\Models\Appointment::with(['patient.user', 'doctor.user'])->latest()->take(5)->get() as $appointment)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">{{ $appointment->appointment_date }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                @if($appointment->status == 'completed')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-900 text-green-300">Completed</span>
                                @elseif($appointment->status == 'upcoming')
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-900 text-blue-300">Upcoming</span>
                                @elseif($appointment->status == 'cancelled')
                                <span class="px-2 py-1 text-xs rounded-full bg-red-900 text-red-300">Cancelled</span>
                                @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-900 text-yellow-300">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Doctors List -->
        <div class="bg-secondary p-6 rounded-xl shadow-lg border border-borderColor md:col-span-1">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Recent Doctors</h3>
                <a href="{{ route('admin.users') }}" class="text-teal-500 text-sm hover:underline">View All</a>
            </div>
            <div class="space-y-4">
                @foreach(\App\Models\Doctor::with('user')->latest()->take(3)->get() as $doctor)
                <div class="flex items-center p-3 bg-gray-800 rounded-lg">
                    <div class="flex-shrink-0 h-10 w-10">
                        @if($doctor->user->image)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $doctor->user->image) }}" alt="{{ $doctor->user->name }}">
                        @else
                        <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400">{{ substr($doctor->user->name, 0, 1) }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-white">{{ $doctor->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $doctor->speciality }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Diseases List -->
        <div class="bg-secondary p-6 rounded-xl shadow-lg border border-borderColor md:col-span-1">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Disease Library</h3>
                <a href="{{ route('admin.diseases') }}" class="text-teal-500 text-sm hover:underline">View All</a>
            </div>
            <div class="space-y-3">
                @foreach(\App\Models\Disease::latest()->take(4)->get() as $disease)
                <div class="p-3 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-medium text-white">{{ $disease->name }}</h4>
                            <p class="text-xs text-gray-400">{{ $disease->category }}</p>
                        </div>
                        <a href="{{ route('admin.diseases.show', $disease) }}" class="text-teal-500 hover:text-teal-400">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Departments -->
        <div class="bg-secondary p-6 rounded-xl shadow-lg border border-borderColor md:col-span-1">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Departments</h3>
            </div>
            <div class="space-y-3">
                @foreach(\App\Models\Department::take(5)->get() as $department)
                <div class="p-3 bg-gray-800 rounded-lg">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-white">{{ $department->name }}</p>
                            <p class="text-xs text-gray-400">{{ $department->doctors->count() }} Doctors</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Appointment Status Chart
    const appointmentCtx = document.getElementById('appointmentChart').getContext('2d');
    
    // Get appointment stats
    const pendingCount = {{ \App\Models\Appointment::where('status', 'pending')->count() }};
    const upcomingCount = {{ \App\Models\Appointment::where('status', 'upcoming')->count() }};
    const completedCount = {{ \App\Models\Appointment::where('status', 'completed')->count() }};
    const cancelledCount = {{ \App\Models\Appointment::where('status', 'cancelled')->count() }};
    
    const appointmentChart = new Chart(appointmentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Upcoming', 'Completed', 'Cancelled'],
            datasets: [{
                data: [pendingCount, upcomingCount, completedCount, cancelledCount],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 193, 7, 1)',
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#E2E2E2',
                        padding: 10,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endsection