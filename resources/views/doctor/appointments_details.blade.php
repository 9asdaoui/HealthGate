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
                            transition: all 0.2s ease;
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

              .action-button {
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            padding: 0.5rem 1rem;
                            font-weight: 500;
                            border-radius: 0.375rem;
                            transition: all 0.2s ease;
                            cursor: pointer;
              }

              .action-button i {
                            margin-right: 0.5rem;
              }
</style>
@endsection

@section('content')
<div class="py-6 px-4 md:px-8">
              <!-- Back button -->
              <div class="mb-4">
                            <a href="{{ route('doctor.appointments') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                          <i class="fas fa-arrow-left mr-2"></i>
                                          <span>Back to Appointments</span>
                            </a>
              </div>

              <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column - Appointment Details -->
                            <div class="lg:col-span-2">
                                          <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                                                        <div class="flex items-center justify-between mb-6">
                                                                      <h2 class="text-xl font-bold text-gray-800">Appointment Details</h2>
                                                                      <span class="status-badge status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                                        </div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                                                      <div>
                                                                                    <p class="text-sm text-gray-500 mb-1">Appointment Date</p>
                                                                                    <p class="text-base font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                                                                      </div>
                                                                      <div>
                                                                                    <p class="text-sm text-gray-500 mb-1">Appointment Time</p>
                                                                                    <p class="text-base font-medium">{{ $appointment->appointment_time }}</p>
                                                                      </div>
                                                                      <div>
                                                                                    <p class="text-sm text-gray-500 mb-1">Booking ID</p>
                                                                                    <p class="text-base font-medium">#APT-{{ $appointment->id }}</p>
                                                                      </div>
                                                                      <div>
                                                                                    <p class="text-sm text-gray-500 mb-1">Created On</p>
                                                                                    <p class="text-base font-medium">{{ $appointment->created_at->format('M d, Y h:i A') }}</p>
                                                                      </div>
                                                        </div>

                                                        <div class="mb-6">
                                                                      <h3 class="text-lg font-semibold text-gray-800 mb-3">Reason for Visit</h3>
                                                                      <div class="bg-gray-50 p-4 rounded-lg">
                                                                                    <p class="text-gray-700">{{ $appointment->reason ?? 'No reason provided' }}</p>
                                                                      </div>
                                                        </div>

                                                        @if($appointment->status == 'pending')
                                                        <div class="flex flex-col sm:flex-row gap-3">
                                                                      <form action="{{ route('doctor.appointments.confirm', $appointment) }}" method="POST">
                                                                                    @csrf
                                                                                    <button type="submit" class="action-button bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 w-full sm:w-auto">
                                                                                                  <i class="fas fa-check"></i> Confirm
                                                                                    </button>
                                                                      </form>
                                                                      
                                                                      <form action="{{ route('doctor.appointments.reject', $appointment) }}" method="POST">
                                                                                    @csrf
                                                                                    <button type="submit" class="action-button bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 w-full sm:w-auto">
                                                                                                  <i class="fas fa-times"></i> Reject
                                                                                    </button>
                                                                      </form>
                                                        </div>
                                                        @elseif($appointment->status == 'upcoming')
                                                        <div class="flex flex-col sm:flex-row gap-3">
                                                                      <form action="{{ route('doctor.appointments.complete', $appointment) }}" method="POST">
                                                                                    @csrf
                                                                                    <button type="submit" class="action-button bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 w-full sm:w-auto">
                                                                                                  <i class="fas fa-check-double"></i> Mark as Completed
                                                                                    </button>
                                                                      </form>
                                                                      
                                                                      <button type="button" onclick="openAddPrescriptionModal()" class="action-button bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 w-full sm:w-auto">
                                                                                    <i class="fas fa-prescription"></i> Add Prescription
                                                                      </button>
                                                        </div>
                                                        @endif
                                          </div>

                                          <!-- Medical Records Section -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <div class="flex items-center justify-between mb-6">
                                                                      <h2 class="text-xl font-bold text-gray-800">Medical Records</h2>
                                                                      <button type="button" onclick="openAddMedicalRecordModal()" class="text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-1.5 rounded-lg flex items-center">
                                                                                    <i class="fas fa-plus mr-1"></i> Add Prescription
                                                                      </button>
                                                        </div>

                                                        <div class="space-y-4">
                                                                      <!-- Sample Medical Records - Replace with actual data when available -->
                                                                      @forelse($appointment->patient->medicals->where('doctor_id', $user->doctor->id)->take(3) as $medical)
                                                                      <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                                                                                    <div class="flex justify-between">
                                                                                                  <h4 class="font-medium text-gray-800">{{ $medical->name }}</h4>
                                                                                                  <span class="text-xs text-gray-500">{{ $medical->created_at->format('M d, Y') }}</span>
                                                                                    </div>
                                                                                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($medical->description, 100) }}</p>
                                                                      </div>
                                                                      @empty
                                                                      <div class="text-center py-6">
                                                                                    <i class="fas fa-notes-medical text-gray-300 text-4xl mb-3"></i>
                                                                                    <p class="text-gray-500">No medical records found for this patient</p>
                                                                      </div>
                                                                      @endforelse
                                                                      
                                                                      @if($appointment->patient->medicals->where('doctor_id', $user->doctor->id)->count() > 3)
                                                                      <div class="mt-4 text-center">
                                                                                    <a href="{{ route('doctor.medical-records') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                                                                  View All Medical Records
                                                                                    </a>
                                                                      </div>
                                                                      @endif
                                                        </div>
                                          </div>
                            </div>

                            <!-- Right Column - Patient Info and Health Metrics -->
                            <div class="lg:col-span-1 space-y-6">
                                          <!-- Patient Info -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <h2 class="text-xl font-bold text-gray-800 mb-4">Patient Information</h2>
                                                        
                                                        <div class="flex items-center mb-6">
                                                                      <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden mr-4">
                                                                                    @if($appointment->patient->user->image)
                                                                                                  <img src="{{ $appointment->patient->user->image }}" alt="Patient photo" class="h-full w-full object-cover">
                                                                                    @else
                                                                                                  <i class="fas fa-user text-gray-400 text-2xl"></i>
                                                                                    @endif
                                                                      </div>
                                                                      <div>
                                                                                    <h3 class="font-medium text-gray-800">{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</h3>
                                                                                    <p class="text-sm text-gray-500">
                                                                                                  {{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} years old, 
                                                                                                  {{ ucfirst($appointment->patient->user->gender ?? 'Not specified') }}
                                                                                    </p>
                                                                      </div>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-4 mb-6 border-t border-b border-gray-100 py-4">
                                                                      <div>
                                                                                    <p class="text-xs text-gray-500">Height</p>
                                                                                    <p class="font-medium">{{ $appointment->patient->height ?? 'N/A' }} cm</p>
                                                                      </div>
                                                                      <div>
                                                                                    <p class="text-xs text-gray-500">Weight</p>
                                                                                    <p class="font-medium">{{ $appointment->patient->weight ?? 'N/A' }} kg</p>
                                                                      </div>
                                                        </div>

                                                        <div class="flex justify-center">
                                                                      <a href="{{ route('doctor.patients') }}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                                                                    <i class="fas fa-user-circle mr-1"></i> View Full Profile
                                                                      </a>
                                                        </div>
                                          </div>

                                          <!-- Health Metrics -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest Health Metrics</h2>
                                                        
                                                        <div class="space-y-4">
                                                                      <!-- Heart Rate -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 bg-red-50">
                                                                                    <div class="flex items-center mb-2">
                                                                                                  <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                                                                                                  <h4 class="font-medium text-gray-800">Heart Rate</h4>
                                                                                    </div>
                                                                                    @if($heartRate = $appointment->patient->hearthRates->last())
                                                                                                  <p class="text-xl font-bold">{{ $heartRate->value }} <span class="text-sm font-normal">BPM</span></p>
                                                                                                  <p class="text-xs text-gray-500">Measured on {{ \Carbon\Carbon::parse($heartRate->measured_at)->format('M d, Y') }}</p>
                                                                                    @else
                                                                                                  <p class="text-gray-500 text-sm">No data available</p>
                                                                                    @endif
                                                                      </div>
                                                                      
                                                                      <!-- Blood Pressure -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 bg-blue-50">
                                                                                    <div class="flex items-center mb-2">
                                                                                                  <i class="fas fa-stethoscope text-blue-500 mr-2"></i>
                                                                                                  <h4 class="font-medium text-gray-800">Blood Pressure</h4>
                                                                                    </div>
                                                                                    @if($bloodPressure = $appointment->patient->bloodPressures->last())
                                                                                                  <p class="text-xl font-bold">{{ $bloodPressure->systolic }}/{{ $bloodPressure->diastolic }} <span class="text-sm font-normal">mmHg</span></p>
                                                                                                  <p class="text-xs text-gray-500">Measured on {{ \Carbon\Carbon::parse($bloodPressure->measured_at)->format('M d, Y') }}</p>
                                                                                    @else
                                                                                                  <p class="text-gray-500 text-sm">No data available</p>
                                                                                    @endif
                                                                      </div>
                                                                      
                                                                      <!-- Blood Sugar -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 bg-yellow-50">
                                                                                    <div class="flex items-center mb-2">
                                                                                                  <i class="fas fa-tint text-yellow-500 mr-2"></i>
                                                                                                  <h4 class="font-medium text-gray-800">Blood Sugar</h4>
                                                                                    </div>
                                                                                    @if($bloodSugar = $appointment->patient->bloodSugars->last())
                                                                                                  <p class="text-xl font-bold">{{ $bloodSugar->vlalue }} <span class="text-sm font-normal">{{ $bloodSugar->unit }}</span></p>
                                                                                                  <p class="text-xs text-gray-500">Measured on {{ \Carbon\Carbon::parse($bloodSugar->measurde_at)->format('M d, Y') }}</p>
                                                                                    @else
                                                                                                  <p class="text-gray-500 text-sm">No data available</p>
                                                                                    @endif
                                                                      </div>
                                                        </div>

                                                        <div class="mt-4 text-center">
                                                                      <a href="{{ route('doctor.health-metrics') }}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center justify-center">
                                                                                    <i class="fas fa-chart-line mr-1"></i> View All Metrics
                                                                      </a>
                                                        </div>
                                          </div>
                            </div>
              </div>
</div>

<!-- Add Prescription Modal -->
<div id="prescriptionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
              <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                                          <h3 class="text-lg font-bold text-gray-800">Add New Prescription</h3>
                                          <button type="button" onclick="closePrescriptionModal()" class="text-gray-400 hover:text-gray-600">
                                                        <i class="fas fa-times"></i>
                                          </button>
                            </div>
                            
                            <form action="#" method="POST" class="px-6 py-4">
                                          @csrf
                                          <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                          <input type="hidden" name="doctor_id" value="{{ $user->doctor->id }}">
                                          
                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="medication_name">
                                                                      Medication Name
                                                        </label>
                                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                      type="text" id="medication_name" name="name" required>
                                          </div>
                                          
                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="dosage">
                                                                      Dosage
                                                        </label>
                                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                      type="text" id="dosage" name="dosage" placeholder="e.g., 500mg" required>
                                          </div>
                                          
                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="frequency">
                                                                      Frequency
                                                        </label>
                                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                      type="text" id="frequency" name="frequency" placeholder="e.g., Twice daily" required>
                                          </div>
                                          
                                          <div class="grid grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                                      <label class="block text-gray-700 text-sm font-medium mb-2" for="start_date">
                                                                                    Start Date
                                                                      </label>
                                                                      <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                                    type="date" id="start_date" name="start_date" required>
                                                        </div>
                                                        <div>
                                                                      <label class="block text-gray-700 text-sm font-medium mb-2" for="end_date">
                                                                                    End Date
                                                                      </label>
                                                                      <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                                    type="date" id="end_date" name="end_date" required>
                                                        </div>
                                          </div>
                                          
                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="description">
                                                                      Instructions/Notes
                                                        </label>
                                                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                      id="description" name="description" rows="3"></textarea>
                                          </div>
                                          
                                          <div class="flex justify-end pt-4 border-t border-gray-200">
                                                        <button type="button" onclick="closePrescriptionModal()" class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                                                      Cancel
                                                        </button>
                                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                                      Save Prescription
                                                        </button>
                                          </div>
                            </form>
              </div>
</div>

<!-- Add Medical Record Modal -->
<div id="medicalRecordModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
              <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                                          <h3 class="text-lg font-bold text-gray-800">Add Medical Record</h3>
                                          <button type="button" onclick="closeMedicalRecordModal()" class="text-gray-400 hover:text-gray-600">
                                                        <i class="fas fa-times"></i>
                                          </button>
                            </div>
                            
                            <form action="#" method="POST" class="px-6 py-4">
                                          @csrf
                                          <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                          <input type="hidden" name="doctor_id" value="{{ $user->doctor->id }}">
                                          
                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="record_name">
                                                                      Record Title
                                                        </label>
                                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                      type="text" id="record_name" name="name" required>
                                          </div>
                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="record_type">
                                                                      Record Type
                                                        </label>
                                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                                    id="record_type" name="record_type" required>
                                                                      <option value="">Select record type</option>
                                                                      <option value="diagnosis">Diagnosis</option>
                                                                      <option value="test">Test Result</option>
                                                                      <option value="procedure">Procedure</option>
                                                                      <option value="allergy">Allergy</option>
                                                                      <option value="other">Other</option>
                                                        </select>
                                          </div>

                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="record_description">
                                                                      Description
                                                        </label>
                                                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                                    id="record_description" name="description" rows="4" required></textarea>
                                          </div>

                                          <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-medium mb-2" for="record_date">
                                                                      Record Date
                                                        </label>
                                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                                                    type="date" id="record_date" name="record_date" value="{{ date('Y-m-d') }}" required>
                                          </div>

                                          <div class="flex justify-end pt-4 border-t border-gray-200">
                                                        <button type="button" onclick="closeMedicalRecordModal()" class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                                                      Cancel
                                                        </button>
                                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                                      Save Record
                                                        </button>
                                          </div>
                                          </form>
                                          </div>
                                          </div>

                                          @push('scripts')
                                          <script>
                                          function openAddPrescriptionModal() {
                                                        document.getElementById('prescriptionModal').classList.remove('hidden');
                                                        document.body.style.overflow = 'hidden';
                                          }

                                          function closePrescriptionModal() {
                                                        document.getElementById('prescriptionModal').classList.add('hidden');
                                                        document.body.style.overflow = 'auto';
                                          }

                                          function openAddMedicalRecordModal() {
                                                        document.getElementById('medicalRecordModal').classList.remove('hidden');
                                                        document.body.style.overflow = 'hidden';
                                          }

                                          function closeMedicalRecordModal() {
                                                        document.getElementById('medicalRecordModal').classList.add('hidden');
                                                        document.body.style.overflow = 'auto';
                                          }

                                          // Set default dates for prescription form
                                          document.addEventListener('DOMContentLoaded', function() {
                                                        const today = new Date();
                                                        const nextMonth = new Date();
                                                        nextMonth.setMonth(today.getMonth() + 1);
                                                        
                                                        if (document.getElementById('start_date')) {
                                                                      document.getElementById('start_date').valueAsDate = today;
                                                        }
                                                        
                                                        if (document.getElementById('end_date')) {
                                                                      document.getElementById('end_date').valueAsDate = nextMonth;
                                                        }
                                          });
                                          </script>
                                          @endpush
                                          @endsection