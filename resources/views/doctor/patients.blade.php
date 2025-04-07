@extends('layouts.doctor')

@section('title', 'My Patients')

@section('page-title', 'My Patients')

@section('breadcrumb', 'My Patients')

@section('content')
<div class="mb-6 flex justify-between items-center">
              <h1 class="text-2xl font-semibold text-gray-800">Patient Management</h1>
            
</div>

<div class="bg-white rounded-xl shadow-card p-6 mb-6">
              <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-medium text-gray-800">My Patients ({{ $patients->count() }})</h2>
                            <div class="text-sm text-accent">
                                          <i class="fas fa-user-plus mr-1"></i>
                                          <span>Patients under your care</span>
                            </div>
              </div>
              
              @if($patients->count() > 0)
              <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg">
                                          <thead>
                                                        <tr class="bg-gray-100 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                                      <th class="px-6 py-3 rounded-tl-lg">Patient</th>
                                                                      <th class="px-6 py-3">Contact</th>
                                                                      <th class="px-6 py-3">Last Visit</th>
                                                                      <th class="px-6 py-3">Status</th>
                                                                      <th class="px-6 py-3 rounded-tr-lg">Actions</th>
                                                        </tr>
                                          </thead>
                                          <tbody class="text-sm">
                                                        @foreach($patients as $patient)
                                                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                                                                      <td class="px-6 py-4">
                                                                                    <div class="flex items-center space-x-3">
                                                                                                  <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                                                                                                                @if($patient->image)
                                                                                                                <img src="{{ $patient->image }}" alt="Patient photo" class="h-full w-full object-cover">
                                                                                                                @else
                                                                                                                <span class="text-blue-500 font-semibold">{{ substr($patient->first_name, 0, 1) }}</span>
                                                                                                                @endif
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="font-medium text-gray-800">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                                                                                                <p class="text-xs text-gray-500">ID: #{{ $patient->id }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                      </td>
                                                                      <td class="px-6 py-4">
                                                                                    <p class="text-gray-700">{{ $patient->email }}</p>
                                                                                    <p class="text-xs text-gray-500">{{ $patient->phone ?? 'No phone' }}</p>
                                                                      </td>
                                                                      <td class="px-6 py-4">
                                                                                    @php
                                                                                                  $lastAppointment = \App\Models\Appointment::where('patient_id', $patient->id)
                                                                                                                ->where('doctor_id', auth()->user()->doctor->id)
                                                                                                                ->orderBy('appointment_date', 'desc')
                                                                                                                ->first();
                                                                                    @endphp
                                                                                    @if($lastAppointment)
                                                                                                  <p class="text-gray-700">{{ \Carbon\Carbon::parse($lastAppointment->appointment_date)->format('M d, Y') }}</p>
                                                                                                  <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($lastAppointment->appointment_date)->diffForHumans() }}</p>
                                                                                    @else
                                                                                                  <p class="text-gray-500">No visits yet</p>
                                                                                    @endif
                                                                      </td>
                                                                      <td class="px-6 py-4">
                                                                                    @php
                                                                                                  $status = $lastAppointment ? $lastAppointment->status : 'new';
                                                                                    @endphp
                                                                                    @if($status == 'completed')
                                                                                                  <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                                                                    @elseif($status == 'pending')
                                                                                                  <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                                                    @elseif($status == 'cancelled')
                                                                                                  <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>
                                                                                    @else
                                                                                                  <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">New</span>
                                                                                    @endif
                                                                      </td>
                                                                      <td class="px-6 py-4">
                                                                                    <div class="flex space-x-2">
                                                                                                  <a href="{{ route('doctor.patients.medical-records',$patient->id) }}" class="tooltip text-accent hover:text-accentHover transition duration-150 ease-in-out flex items-center justify-center h-8 w-8 rounded-full hover:bg-gray-100">
                                                                                                                <i class="fas fa-file-medical"></i>
                                                                                                                <span class="tooltip-text bg-gray-800 text-white text-xs rounded py-1 px-2 absolute -mt-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Medical Records</span>
                                                                                                  </a>

                                                                                                  <a href="{{ route('doctor.appointments',$patient->id ) }}" class="tooltip text-accent hover:text-accentHover transition duration-150 ease-in-out flex items-center justify-center h-8 w-8 rounded-full hover:bg-gray-100">
                                                                                                                <i class="fas fa-calendar-plus"></i>
                                                                                                                <span class="tooltip-text bg-gray-800 text-white text-xs rounded py-1 px-2 absolute -mt-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Schedule Appointment</span>
                                                                                                  </a>

                                                                                          
                                                                                    </div>
                                                                      </td>
                                                        </tr>
                                                        @endforeach
                                          </tbody>
                            </table>
              </div>
              @else
              <div class="text-center py-16">
                            <div class="text-gray-400 mb-4">
                                          <i class="fas fa-user-friends text-5xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">No patients found</h3>
                            <p class="text-gray-500 mb-6">You don't have any patients under your care yet.</p>
                            <a href="{{ route('doctor.appointments') }}" class="px-4 py-2 bg-accent hover:bg-accentHover text-white rounded-lg transition-colors duration-200">
                                          Manage Appointments
                            </a>
              </div>
              @endif
</div>

<!-- Patient Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
              <div class="stat-card p-6">
                            <div class="flex justify-between items-start">
                                          <div>
                                                        <p class="text-gray-500 text-sm">Total Patients</p>
                                                        <h3 class="text-2xl font-semibold text-gray-800">{{ $patients->count() }}</h3>
                                          </div>
                                          <div class="bg-blue-50 p-3 rounded-full">
                                                        <i class="fas fa-users text-blue-500"></i>
                                          </div>
                            </div>
                            <div class="mt-4">
                                          <div class="flex items-center">
                                                        <span class="text-xs text-gray-500">Your patient portfolio</span>
                                          </div>
                            </div>
              </div>
              
              <div class="stat-card p-6">
                            <div class="flex justify-between items-start">
                                          <div>
                                                        <p class="text-gray-500 text-sm">New This Month</p>
                                                        @php
                                                                      $newThisMonth = \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)
                                                                                    ->whereMonth('created_at', now()->month)
                                                                                    ->pluck('patient_id')
                                                                                    ->unique()
                                                                                    ->count();
                                                        @endphp
                                                        <h3 class="text-2xl font-semibold text-gray-800">{{ $newThisMonth }}</h3>
                                          </div>
                                          <div class="bg-green-50 p-3 rounded-full">
                                                        <i class="fas fa-user-plus text-green-500"></i>
                                          </div>
                            </div>
                            <div class="mt-4">
                                          <div class="flex items-center">
                                                        <span class="text-xs text-gray-500">New patients this month</span>
                                          </div>
                            </div>
              </div>
              
              <div class="stat-card p-6">
                            <div class="flex justify-between items-start">
                                          <div>
                                                        <p class="text-gray-500 text-sm">Appointments</p>
                                                        @php
                                                                      $upcomingAppointments = \App\Models\Appointment::where('doctor_id', auth()->user()->doctor->id)
                                                                                    ->where('appointment_date', '>=', now())
                                                                                    ->where('status', 'pending')
                                                                                    ->count();
                                                        @endphp
                                                        <h3 class="text-2xl font-semibold text-gray-800">{{ $upcomingAppointments }}</h3>
                                          </div>
                                          <div class="bg-purple-50 p-3 rounded-full">
                                                        <i class="fas fa-calendar-check text-purple-500"></i>
                                          </div>
                            </div>
                            <div class="mt-4">
                                          <div class="flex items-center">
                                                        <span class="text-xs text-gray-500">Upcoming patient visits</span>
                                          </div>
                            </div>
              </div>
</div>
@endsection