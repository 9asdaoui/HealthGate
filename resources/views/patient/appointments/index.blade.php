@extends('layouts.patient')

@section('title', 'My Appointments')

@section('page-title', 'Patient Appointments')

@section('breadcrumb', 'Appointments')



@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">My Appointments</h2>
                <p class="text-gray-500 mt-1">View and manage your scheduled appointments</p>
            </div>
            <a href="{{ route('patient.appointments.create') }}"
                class="mt-4 md:mt-0 bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                <i class="fas fa-plus-circle mr-2"></i> New Appointment
            </a>
        </div>

        <!-- Appointments List -->
        <div class="bg-white rounded-xl shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Doctor</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                                & Time</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $appointment->doctor->user->image }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Dr.
                                                {{ $appointment->doctor->user->first_name ?? 'Unknown' }}
                                                {{ $appointment->doctor->user->last_name ?? '' }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $appointment->doctor->speciality ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ date('M d, Y', strtotime($appointment->appointment_date)) }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->appointment_time }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'upcoming' => 'bg-blue-100 text-blue-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $class = $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ">
                                    <div class="flex justify-end space-x-3">
                                        @if ($appointment->status == 'upcoming')
                                            <!-- Cancel Button -->
                                            <form action="{{ route('patient.appointments.cancel', $appointment->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="group flex items-center px-3 py-1.5 rounded-md text-sm text-red-600 hover:bg-red-50 transition-all duration-200"
                                                    onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="fas fa-times-circle mr-1.5 group-hover:animate-pulse"></i>
                                                    <span class="font-medium">Cancel</span>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('patient.appointments.show', $appointment->id) }}"
                                            class="flex items-center px-3 py-1.5 rounded-md text-sm bg-accent/10 text-accent hover:bg-accent hover:text-white transition-all duration-300">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            <span class="font-medium">View Details</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-calendar-times text-4xl mb-3"></i>
                                    <p>No appointments found</p>
                                    <a href="{{ route('patient.appointments.create') }}"
                                        class="mt-3 bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                        <i class="fas fa-plus-circle mr-2"></i> Schedule New Appointment
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
