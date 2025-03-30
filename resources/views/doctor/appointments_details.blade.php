@extends('layouts.doctor')

@section('title', 'Appointment Details')

@section('page-title', 'Appointment Details')

@section('styles')
<style>
              .status-badge {
                            padding: 0.35rem 0.75rem;
                            border-radius: 9999px;
                            font-size: 0.75rem;
                            font-weight: 600;
                            display: inline-flex;
                            align-items: center;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                            letter-spacing: 0.025em;
              }

              .status-badge::before {
                            content: '';
                            display: inline-block;
                            width: 0.5rem;
                            height: 0.5rem;
                            border-radius: 50%;
                            margin-right: 0.5rem;
              }

              .status-pending {
                            background-color: #FFF7ED;
                            color: #9A3412;
                            border: 1px solid #FFEDD5;
              }

              .status-pending::before {
                            background-color: #F97316;
              }

              .status-upcoming {
                            background-color: #EFF6FF;
                            color: #1E40AF;
                            border: 1px solid #DBEAFE;
              }

              .status-upcoming::before {
                            background-color: #3B82F6;
              }

              .status-completed {
                            background-color: #ECFDF5;
                            color: #065F46;
                            border: 1px solid #D1FAE5;
              }

              .status-completed::before {
                            background-color: #10B981;
              }

              .status-cancelled {
                            background-color: #FEF2F2;
                            color: #B91C1C;
                            border: 1px solid #FEE2E2;
              }

              .status-cancelled::before {
                            background-color: #EF4444;
              }

              .modal {
                            display: none;
                            position: fixed;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            background-color: rgba(0, 0, 0, 0.5);
                            z-index: 50;
                            overflow-y: auto;
              }

              .modal-open {
                            display: block;
              }
</style>
@endsection

@section('content')
<div class="p-4 sm:p-6 md:p-8 bg-gray-50">
              <!-- Back button -->
              <div class="mb-6">
                            <a href="{{ route('doctor.appointments') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                          </svg>
                                          Back to Appointments
                            </a>
              </div>

              <!-- Main content -->
              <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left column - Appointment details -->
                            <div class="lg:col-span-2">
                                          <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                                        <div class="p-6 border-b border-gray-200">
                                                                      <div class="flex justify-between items-start">
                                                                                    <div>
                                                                                                  <span class="status-badge status-{{ $appointment->status }}">
                                                                                                                {{ ucfirst($appointment->status) }}
                                                                                                  </span>
                                                                                                  <h1 class="text-2xl font-bold text-gray-900 mt-3">Appointment #{{ $appointment->id }}</h1>
                                                                                    </div>
                                                                                    <div class="flex space-x-2">
                                                                                                  @if($appointment->status == 'pending')
                                                                                                                <form action="{{ route('doctor.appointments.confirm', $appointment) }}" method="POST">
                                                                                                                              @csrf
                                                                                                                              <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                                                                                            Confirm
                                                                                                                              </button>
                                                                                                                </form>
                                                                                                                <form action="{{ route('doctor.appointments.reject', $appointment) }}" method="POST">
                                                                                                                              @csrf
                                                                                                                              <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                                                                                                            Reject
                                                                                                                              </button>
                                                                                                                </form>
                                                                                                  @elseif($appointment->status == 'upcoming')
                                                                                                                <form action="{{ route('doctor.appointments.complete', $appointment) }}" method="POST">
                                                                                                                              @csrf
                                                                                                                              <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                                                                                                            Mark Completed
                                                                                                                              </button>
                                                                                                                </form>
                                                                                                  @endif
                                                                                    </div>
                                                                      </div>
                                                        </div>

                                                        <div class="p-6">
                                                                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                                    <div>
                                                                                                  <h2 class="text-lg font-semibold text-gray-800 mb-3">Appointment Information</h2>
                                                                                                  <div class="space-y-3">
                                                                                                                <div class="flex justify-between">
                                                                                                                              <span class="text-gray-600">Date:</span>
                                                                                                                              <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                                                                                                </div>
                                                                                                                <div class="flex justify-between">
                                                                                                                              <span class="text-gray-600">Time:</span>
                                                                                                                              <span class="font-medium">{{ $appointment->appointment_time }}</span>
                                                                                                                </div>
                                                                                                                <div class="flex justify-between">
                                                                                                                              <span class="text-gray-600">Created at:</span>
                                                                                                                              <span class="font-medium">{{ $appointment->created_at->format('M d, Y H:i') }}</span>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    </div>
                                                                                    
                                                                                    <div>
                                                                                                  <h2 class="text-lg font-semibold text-gray-800 mb-3">Reason for Visit</h2>
                                                                                                  <p class="text-gray-700 bg-gray-50 p-3 rounded-md border border-gray-200">
                                                                                                                {{ $appointment->reason ?? 'No reason provided' }}
                                                                                                  </p>
                                                                                    </div>
                                                                      </div>
                                                        </div>
                                          </div>

                                          <!-- Patient Vitals and Health Metrics -->
                                          <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
                                                        <div class="p-6 border-b border-gray-200">
                                                                      <h2 class="text-xl font-bold text-gray-900">Patient Health Summary</h2>
                                                        </div>

                                                        <div class="p-6">
                                                                      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                    <!-- Blood Pressure -->
                                                                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                                                                                  <div class="flex justify-between items-center">
                                                                                                                <div>
                                                                                                                              <p class="text-sm text-gray-500">Latest Blood Pressure</p>
                                                                                                                              @php
                                                                                                                                            $latestBP = $appointment->patient->bloodPressures()
                                                                                                                                                          ->latest('date')->first();
                                                                                                                              @endphp
                                                                                                                              
                                                                                                                              @if($latestBP)
                                                                                                                                            <p class="text-xl font-bold text-gray-800">{{ $latestBP->systolic }}/{{ $latestBP->diastolic }} mmHg</p>
                                                                                                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($latestBP->date)->format('M d, Y') }}</p>
                                                                                                                              @else
                                                                                                                                            <p class="text-sm italic text-gray-500">No data available</p>
                                                                                                                              @endif
                                                                                                                </div>
                                                                                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                                                                                              <i class="fas fa-heartbeat text-blue-500"></i>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    </div>

                                                                                    <!-- Heart Rate -->
                                                                                    <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                                                                                                  <div class="flex justify-between items-center">
                                                                                                                <div>
                                                                                                                              <p class="text-sm text-gray-500">Latest Heart Rate</p>
                                                                                                                              @php
                                                                                                                                            $latestHR = $appointment->patient->hearthRates()
                                                                                                                                                          ->latest('measured_at')->first();
                                                                                                                              @endphp
                                                                                                                              
                                                                                                                              @if($latestHR)
                                                                                                                                            <p class="text-xl font-bold text-gray-800">{{ $latestHR->value }} {{ $latestHR->unit }}</p>
                                                                                                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($latestHR->measured_at)->format('M d, Y') }}</p>
                                                                                                                              @else
                                                                                                                                            <p class="text-sm italic text-gray-500">No data available</p>
                                                                                                                              @endif
                                                                                                                </div>
                                                                                                                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                                                                                                              <i class="fas fa-heart text-red-500"></i>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    </div>

                                                                                    <!-- Blood Sugar -->
                                                                                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                                                                                  <div class="flex justify-between items-center">
                                                                                                                <div>
                                                                                                                              <p class="text-sm text-gray-500">Latest Blood Sugar</p>
                                                                                                                              @php
                                                                                                                                            $latestBS = $appointment->patient->bloodSugars()
                                                                                                                                                          ->latest('date')->first();
                                                                                                                              @endphp
                                                                                                                              
                                                                                                                              @if($latestBS)
                                                                                                                                            <p class="text-xl font-bold text-gray-800">{{ $latestBS->blood_sugar }} mg/dL</p>
                                                                                                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($latestBS->date)->format('M d, Y') }}</p>
                                                                                                                              @else
                                                                                                                                            <p class="text-sm italic text-gray-500">No data available</p>
                                                                                                                              @endif
                                                                                                                </div>
                                                                                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                                                                                              <i class="fas fa-tint text-green-500"></i>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <!-- Add new health metrics button -->
                                                                      <div class="mt-4 flex justify-end">
                                                                                    <button id="addHealthMetricsBtn" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                                                                                  <i class="fas fa-plus-circle mr-1"></i> Add Health Metrics
                                                                                    </button>
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>

                            <!-- Right column - Patient info -->
                            <div class="lg:col-span-1">
                                          <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                                        <div class="p-6 border-b border-gray-200">
                                                                      <h2 class="text-lg font-semibold text-gray-800">Patient Information</h2>
                                                        </div>
                                                        
                                                        <div class="p-6">
                                                                      <div class="flex items-center mb-6">
                                                                                    <div class="h-20 w-20 rounded-full bg-gray-200 border-4 border-white shadow-md overflow-hidden mr-4">
                                                                                                  @if($appointment->patient->user->image)
                                                                                                                <img src="{{ $appointment->patient->user->image }}" alt="Patient photo" class="h-full w-full object-cover">
                                                                                                  @else
                                                                                                                <div class="h-full w-full flex items-center justify-center bg-blue-100 text-blue-500">
                                                                                                                              <i class="fas fa-user text-2xl"></i>
                                                                                                                </div>
                                                                                                  @endif
                                                                                    </div>
                                                                                    <div>
                                                                                                  <h3 class="text-xl font-bold text-gray-800">
                                                                                                                {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}
                                                                                                  </h3>
                                                                                                  <p class="text-sm text-gray-500">
                                                                                                                {{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} years old, 
                                                                                                                {{ $appointment->patient->user->gender }}
                                                                                                  </p>
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <div class="space-y-4">
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Email</p>
                                                                                                  <p class="font-medium">{{ $appointment->patient->user->email }}</p>
                                                                                    </div>
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Birth Date</p>
                                                                                                  <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->format('M d, Y') }}</p>
                                                                                    </div>
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Height</p>
                                                                                                  <p class="font-medium">{{ $appointment->patient->height ?? '-' }} cm</p>
                                                                                    </div>
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Weight</p>
                                                                                                  <p class="font-medium">{{ $appointment->patient->weight ?? '-' }} kg</p>
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <div class="mt-6 space-y-4">
                                                                                    <button id="addPrescriptionBtn" class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center">
                                                                                                  <i class="fas fa-prescription-bottle-alt mr-2"></i> Add Prescription
                                                                                    </button>
                                                                                    
                                                                                    <button id="addMedicalRecordBtn" class="w-full py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center justify-center">
                                                                                                  <i class="fas fa-file-medical mr-2"></i> Add Medical Record
                                                                                    </button>
                                                                      </div>
                                                        </div>
                                          </div>
                                          
                                          <!-- Patient Medical History -->
                                          <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
                                                        <div class="p-6 border-b border-gray-200">
                                                                      <h2 class="text-lg font-semibold text-gray-800">Medical History</h2>
                                                        </div>
                                                        
                                                        <div class="p-6">
                                                                      <h3 class="text-sm font-medium text-gray-700 mb-3">Known Conditions</h3>
                                                                      <div class="space-y-2">
                                                                                    @forelse($appointment->patient->diseases as $disease)
                                                                                                  <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                                                                                                <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                                                                                                              <i class="fas fa-disease text-red-500"></i>
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                              <p class="font-medium text-gray-800">{{ $disease->name }}</p>
                                                                                                                              <p class="text-xs text-gray-500">Duration: {{ $disease->pivot->duration ?? 'Unknown' }}</p>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    @empty
                                                                                                  <p class="text-sm text-gray-500 italic">No known conditions</p>
                                                                                    @endforelse
                                                                      </div>
                                                                      
                                                                      <h3 class="text-sm font-medium text-gray-700 mt-6 mb-3">Current Medications</h3>
                                                                      <div class="space-y-2">
                                                                                    @forelse($appointment->patient->medicals as $medication)
                                                                                                  <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                                                                                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                                                                                              <i class="fas fa-pills text-blue-500"></i>
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                              <p class="font-medium text-gray-800">{{ $medication->name }}</p>
                                                                                                                              <p class="text-xs text-gray-500">
                                                                                                                                            {{ $medication->dosage }}, {{ $medication->frequency }}
                                                                                                                              </p>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    @empty
                                                                                                  <p class="text-sm text-gray-500 italic">No current medications</p>
                                                                                    @endforelse
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>
              </div>
</div>

<!-- Add Prescription Modal -->
<div id="prescriptionModal" class="modal">
              <div class="min-h-screen pt-4 px-4 pb-20 text-center flex justify-center items-center">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full p-6">
                                          <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-bold text-gray-900">Add New Prescription</h3>
                                                        <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                                                                      <i class="fas fa-times"></i>
                                                        </button>
                                          </div>
                                          
                                          <form action="#" method="POST" class="space-y-4">
                                                        @csrf
                                                        <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                                        <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                                                        
                                                        <div>
                                                                      <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Medication Name</label>
                                                                      <input type="text" id="name" name="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        </div>
                                                        
                                                        <div>
                                                                      <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                                      <textarea id="description" name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-2 gap-4">
                                                                      <div>
                                                                                    <label for="dosage" class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                                                                                    <input type="text" id="dosage" name="dosage" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                                      </div>
                                                                      
                                                                      <div>
                                                                                    <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">Frequency</label>
                                                                                    <input type="text" id="frequency" name="frequency" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-2 gap-4">
                                                                      <div>
                                                                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                                                                    <input type="date" id="start_date" name="start_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                                      </div>
                                                                      
                                                                      <div>
                                                                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                                                                    <input type="date" id="end_date" name="end_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                                      </div>
                                                        </div>
                                                        