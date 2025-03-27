@extends('layouts.patient')

@section('title', 'Appointment Details')

@section('page-title', 'Appointment Details')

@section('breadcrumb', 'Appointments')

@section('content')
<div class="space-y-6">
              <!-- Back button -->
              <div class="mb-4">
                            <a href="{{ route('patient.appointments') }}" class="inline-flex items-center text-gray-600 hover:text-accent transition-colors">
                                          <i class="fas fa-arrow-left mr-2"></i> Back to appointments
                            </a>
              </div>
              
              <!-- Appointment Status Banner -->
              <div class="rounded-xl overflow-hidden">
                            @php
                                          $bannerClasses = [
                                                        'pending' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                                                        'upcoming' => 'bg-green-50 border-green-200 text-green-800',
                                                        'cancelled' => 'bg-red-50 border-red-200 text-red-800',
                                                        'completed' => 'bg-blue-50 border-blue-200 text-blue-800',
                                          ];
                                          $iconClasses = [
                                                        'pending' => 'fas fa-clock text-yellow-500',
                                                        'upcoming' => 'fas fa-check-circle text-green-500',
                                                        'cancelled' => 'fas fa-times-circle text-red-500',
                                                        'completed' => 'fas fa-check-double text-blue-500',
                                          ];
                                          $bannerClass = $bannerClasses[$appointment->status] ?? 'bg-gray-50 border-gray-200 text-gray-800';
                                          $iconClass = $iconClasses[$appointment->status] ?? 'fas fa-info-circle text-gray-500';
                            @endphp
                            <div class="border-l-4 {{ $bannerClass }} p-4">
                                          <div class="flex items-center">
                                                        <div class="flex-shrink-0">
                                                                      <i class="{{ $iconClass }} text-2xl"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                                      <h3 class="text-lg font-medium">Appointment {{ ucfirst($appointment->status) }}</h3>
                                                                      <div class="mt-1 text-sm">
                                                                                    @if($appointment->status == 'pending')
                                                                                                  Your appointment is waiting for confirmation from the doctor.
                                                                                    @elseif($appointment->status == 'upcoming')
                                                                                                  Your appointment has been confirmed. Please arrive 15 minutes before your scheduled time.
                                                                                    @elseif($appointment->status == 'cancelled')
                                                                                                  This appointment has been cancelled.
                                                                                    @elseif($appointment->status == 'completed')
                                                                                                  This appointment has been completed.
                                                                                    @endif
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>
              </div>

              <!-- Appointment Details Card -->
              <div class="bg-white rounded-xl shadow-card overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                          <h2 class="text-xl font-semibold text-gray-800">Appointment Information</h2>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6 p-6">
                                          <!-- Left column - Doctor info -->
                                          <div class="space-y-6">
                                                        <div class="flex items-start space-x-4">
                                                                      <div class="flex-shrink-0">
                                                                                    <img class="h-16 w-16 rounded-full object-cover" 
                                                                                                   src="{{ $appointment->doctor->user->image ?? asset('images/default-doctor.png') }}" 
                                                                                                   alt="Doctor profile">
                                                                      </div>
                                                                      <div>
                                                                                    <h3 class="text-lg font-medium text-gray-800">Dr. {{ $appointment->doctor->user->first_name ?? '' }} {{ $appointment->doctor->user->last_name ?? '' }}</h3>
                                                                                    <p class="text-gray-600">{{ $appointment->doctor->speciality }}</p>
                                                                                    <p class="text-gray-500 text-sm mt-1">
                                                                                                  <i class="fas fa-hospital-alt mr-1"></i> {{ $appointment->doctor->department->name ?? 'Department not assigned' }}
                                                                                    </p>
                                                                      </div>
                                                        </div>

                                                        <div class="border-t border-gray-100 pt-4">
                                                                      <h4 class="font-medium text-gray-700 mb-3">Doctor Information</h4>
                                                                      <div class="space-y-2">
                                                                                    <div class="flex items-center text-sm">
                                                                                                  <i class="fas fa-user-md text-accent w-5"></i>
                                                                                                  <span class="text-gray-600">Experience: {{ $appointment->doctor->experience ?? 'N/A' }} years</span>
                                                                                    </div>
                                                                                    <div class="flex items-center text-sm">
                                                                                                  <i class="fas fa-envelope text-accent w-5"></i>
                                                                                                  <span class="text-gray-600">{{ $appointment->doctor->user->email ?? 'N/A' }}</span>
                                                                                    </div>
                                                                      </div>
                                                        </div>
                                          </div>

                                          <!-- Right column - Appointment Details -->
                                          <div class="space-y-6">
                                                        <div>
                                                                      <h4 class="font-medium text-gray-700 mb-3">Appointment Details</h4>
                                                                      <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                                                                                    <div class="flex justify-between">
                                                                                                  <span class="text-gray-600">Date:</span>
                                                                                                  <span class="font-medium">{{ date('l, F d, Y', strtotime($appointment->appointment_date)) }}</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                                  <span class="text-gray-600">Time:</span>
                                                                                                  <span class="font-medium">{{ $appointment->appointment_time }}</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                                  <span class="text-gray-600">Status:</span>
                                                                                                  <span class="font-medium capitalize">{{ $appointment->status }}</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                                  <span class="text-gray-600">Reference:</span>
                                                                                                  <span class="font-medium">#APPT-{{ $appointment->id }}</span>
                                                                                    </div>
                                                                      </div>
                                                        </div>

                                                        <div class="border-t border-gray-100 pt-4">
                                                                      <h4 class="font-medium text-gray-700 mb-2">Reason for Visit</h4>
                                                                      <p class="text-gray-600 bg-gray-50 p-3 rounded-lg">
                                                                                    {{ $appointment->reason ?? 'No reason specified' }}
                                                                      </p>
                                                        </div>
                                          </div>
                            </div>

                            <!-- Actions Section -->
                            <div class="border-t border-gray-100 p-6">
                                          <div class="flex flex-wrap gap-3">
                                                        @if($appointment->status == 'pending' || $appointment->status == 'upcoming')
                                                                      <form action="{{ route('patient.appointments.cancel', $appointment) }}" method="POST" class="inline">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                                                                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                                                                                                  <i class="fas fa-times-circle mr-1"></i> Cancel Appointment
                                                                                    </button>
                                                                      </form>
                                                        @endif
                                                        
                                                        
                                                        <a href="{{ route('patient.appointments') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                                                      <i class="fas fa-arrow-left mr-1"></i> Back to List
                                                        </a>
                                          </div>
                            </div>
              </div>

              <div class="bg-white rounded-xl shadow-card overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                          <h2 class="text-xl font-semibold text-gray-800">Location & Instructions</h2>
                            </div>
                            <div class="p-6">
                                          <div class="grid md:grid-cols-2 gap-6">
                                                        <div>
                                                                      <h4 class="font-medium text-gray-700 mb-3">Hospital Address</h4>
                                                                      <address class="not-italic text-gray-600">
                                                                                    <p>HealthGate Medical Center</p>
                                                                                    <p>123 Medical Street</p>
                                                                                    <p>Healthcare District, HC 12345</p>
                                                                      </address>
                                                                      <div class="mt-4">
                                                                                    <h4 class="font-medium text-gray-700 mb-1">Contact</h4>
                                                                                    <p class="text-gray-600">Phone: (123) 456-7890</p>
                                                                      </div>
                                                        </div>
                                                        <div>
                                                                      <h4 class="font-medium text-gray-700 mb-3">Instructions</h4>
                                                                      <ul class="list-disc list-inside text-gray-600 space-y-2">
                                                                                    <li>Please arrive 15 minutes before your appointment time.</li>
                                                                                    <li>Bring your ID and insurance card.</li>
                                                                                    <li>If you have any previous medical records, please bring them with you.</li>
                                                                                    <li>Wear a face mask for the duration of your visit.</li>
                                                                      </ul>
                                                        </div>
                                          </div>
                            </div>
              </div>
</div>

@endsection
