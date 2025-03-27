@extends('layouts.doctor')

@section('title', 'Dashboard')

@section('page-title', 'Doctor Dashboard')

@section('styles')
<style>
              .stat-card {
                            transition: all 0.3s ease;
              }
              .stat-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
              }
              .appointment-card {
                            transition: all 0.2s ease;
              }
              .appointment-card:hover {
                            background-color: rgba(249, 250, 251, 1);
              }
              .chart-container {
                            height: 240px;
              }
</style>
@endsection

@section('content')
<div class="p-6">
              <!-- Welcome Section -->
              <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800">Welcome back, Dr. {{ $user->first_name }} {{ $user->last_name }}!</h2>
                            <p class="text-gray-600">Here's what's happening with your patients today</p>
              </div>

              <!-- Stats Overview -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <!-- Appointments Today -->
                            <div class="bg-white rounded-xl shadow-md p-6 stat-card border-l-4 border-blue-500">
                                          <div class="flex justify-between items-start">
                                                        <div>
                                                                      <p class="text-sm font-medium text-gray-600">Today's Appointments</p>
                                                                      <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                                                                    {{ \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->whereDate('appointment_date', today())
                                                                                                  ->count() }}
                                                                      </h3>
                                                        </div>
                                                        <div class="p-3 bg-blue-100 rounded-full">
                                                                      <i class="fas fa-calendar-day text-blue-500"></i>
                                                        </div>
                                          </div>
                                          <div class="mt-4">
                                                        <a href="{{ route('doctor.appointments') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                                      View all appointments <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                                        </a>
                                          </div>
                            </div>

                            <!-- Total Patients -->
                            <div class="bg-white rounded-xl shadow-md p-6 stat-card border-l-4 border-green-500">
                                          <div class="flex justify-between items-start">
                                                        <div>
                                                                      <p class="text-sm font-medium text-gray-600">Total Patients</p>
                                                                      <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                                                                    {{ \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->distinct('patient_id')
                                                                                                  ->count('patient_id') }}
                                                                      </h3>
                                                        </div>
                                                        <div class="p-3 bg-green-100 rounded-full">
                                                                      <i class="fas fa-users text-green-500"></i>
                                                        </div>
                                          </div>
                                          <div class="mt-4">
                                                        <a href="{{ route('doctor.patients') }}" class="text-sm text-green-600 hover:text-green-800 flex items-center">
                                                                      Manage patients <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                                        </a>
                                          </div>
                            </div>

                            <!-- Pending Appointments -->
                            <div class="bg-white rounded-xl shadow-md p-6 stat-card border-l-4 border-amber-500">
                                          <div class="flex justify-between items-start">
                                                        <div>
                                                                      <p class="text-sm font-medium text-gray-600">Pending Appointments</p>
                                                                      <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                                                                    {{ \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->where('status', 'pending')
                                                                                                  ->count() }}
                                                                      </h3>
                                                        </div>
                                                        <div class="p-3 bg-amber-100 rounded-full">
                                                                      <i class="fas fa-hourglass-half text-amber-500"></i>
                                                        </div>
                                          </div>
                                          <div class="mt-4">
                                                        <a href="{{ route('doctor.appointments') }}?status=pending" class="text-sm text-amber-600 hover:text-amber-800 flex items-center">
                                                                      Review pending <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                                        </a>
                                          </div>
                            </div>

                            <!-- Prescriptions -->
                            <div class="bg-white rounded-xl shadow-md p-6 stat-card border-l-4 border-purple-500">
                                          <div class="flex justify-between items-start">
                                                        <div>
                                                                      <p class="text-sm font-medium text-gray-600">Active Prescriptions</p>
                                                                      <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                                                                    {{ \App\Models\Medical::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->whereDate('end_date', '>=', now())
                                                                                                  ->count() }}
                                                                      </h3>
                                                        </div>
                                                        <div class="p-3 bg-purple-100 rounded-full">
                                                                      <i class="fas fa-prescription text-purple-500"></i>
                                                        </div>
                                          </div>
                                          <div class="mt-4">
                                                        <a href="{{ route('doctor.prescriptions') }}" class="text-sm text-purple-600 hover:text-purple-800 flex items-center">
                                                                      Manage prescriptions <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                                        </a>
                                          </div>
                            </div>
              </div>

              <!-- Main Content Area: Two Columns -->
              <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column -->
                            <div class="lg:col-span-2 space-y-6">
                                          <!-- Today's Appointments -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <div class="flex justify-between items-center mb-6">
                                                                      <h3 class="text-lg font-bold text-gray-800">Today's Appointments</h3>
                                                                      <a href="{{ route('doctor.appointments') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                                                        </div>
                                                        
                                                        <div class="space-y-4">
                                                                      @php
                                                                                    $todayAppointments = \App\Models\Appointment::with('patient.user')
                                                                                                  ->where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->whereDate('appointment_date', today())
                                                                                                  ->orderBy('appointment_time')
                                                                                                  ->take(5)
                                                                                                  ->get();
                                                                      @endphp

                                                                      @forelse($todayAppointments as $appointment)
                                                                                    <div class="flex items-center p-4 border border-gray-100 rounded-lg appointment-card hover:shadow-sm">
                                                                                                  <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center mr-4 overflow-hidden">
                                                                                                                @if($appointment->patient->user->image)
                                                                                                                              <img src="{{ $appointment->patient->user->image }}" alt="Patient" class="h-full w-full object-cover">
                                                                                                                @else
                                                                                                                              <i class="fas fa-user text-gray-400"></i>
                                                                                                                @endif
                                                                                                  </div>
                                                                                                  <div class="flex-1">
                                                                                                                <h4 class="font-medium text-gray-900">{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</h4>
                                                                                                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }} • {{ $appointment->reason }}</p>
                                                                                                  </div>
                                                                                                  <div class="flex space-x-2">
                                                                                                                <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-full">
                                                                                                                              <i class="fas fa-eye"></i>
                                                                                                                </a>
                                                                                                  </div>
                                                                                    </div>
                                                                      @empty
                                                                                    <div class="text-center py-6 text-gray-500">
                                                                                                  <i class="fas fa-calendar-times text-2xl mb-2"></i>
                                                                                                  <p>No appointments scheduled for today</p>
                                                                                                  <a href="{{ route('doctor.schedule') }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Update your availability</a>
                                                                                    </div>
                                                                      @endforelse
                                                        </div>
                                          </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                          <!-- Doctor's Schedule Today -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4">Your Schedule Today</h3>
                                                        <div class="space-y-3">
                                                                      @php
                                                                                    $morningAppointments = \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->whereDate('appointment_date', today())
                                                                                                  ->whereTime('appointment_time', '<=', '12:00:00')
                                                                                                  ->count();
                                                                                    
                                                                                    $afternoonAppointments = \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->whereDate('appointment_date', today())
                                                                                                  ->whereTime('appointment_time', '>', '12:00:00')
                                                                                                  ->whereTime('appointment_time', '<=', '17:00:00')
                                                                                                  ->count();
                                                                                    
                                                                                    $eveningAppointments = \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)
                                                                                                  ->whereDate('appointment_date', today())
                                                                                                  ->whereTime('appointment_time', '>', '17:00:00')
                                                                                                  ->count();
                                                                      @endphp
                                                                      
                                                                      <div class="flex items-center">
                                                                                    <div class="w-24 text-sm text-gray-600">Morning</div>
                                                                                    <div class="flex-1 relative h-4 bg-gray-100 rounded-full overflow-hidden">
                                                                                                  <div class="absolute h-full bg-blue-500 rounded-full" style="width: {{ min($morningAppointments * 20, 100) }}%"></div>
                                                                                    </div>
                                                                                    <div class="ml-3 font-medium">{{ $morningAppointments }}</div>
                                                                      </div>
                                                                      
                                                                      <div class="flex items-center">
                                                                                    <div class="w-24 text-sm text-gray-600">Afternoon</div>
                                                                                    <div class="flex-1 relative h-4 bg-gray-100 rounded-full overflow-hidden">
                                                                                                  <div class="absolute h-full bg-amber-500 rounded-full" style="width: {{ min($afternoonAppointments * 20, 100) }}%"></div>
                                                                                    </div>
                                                                                    <div class="ml-3 font-medium">{{ $afternoonAppointments }}</div>
                                                                      </div>
                                                                      
                                                                      <div class="flex items-center">
                                                                                    <div class="w-24 text-sm text-gray-600">Evening</div>
                                                                                    <div class="flex-1 relative h-4 bg-gray-100 rounded-full overflow-hidden">
                                                                                                  <div class="absolute h-full bg-purple-500 rounded-full" style="width: {{ min($eveningAppointments * 20, 100) }}%"></div>
                                                                                    </div>
                                                                                    <div class="ml-3 font-medium">{{ $eveningAppointments }}</div>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="mt-6 pt-4 border-t border-gray-100">
                                                                      <a href="{{ route('doctor.schedule') }}" class="text-blue-600 text-sm hover:underline flex items-center justify-center">
                                                                                    <i class="fas fa-calendar-alt mr-2"></i> Manage your schedule
                                                                      </a>
                                                        </div>
                                          </div>
                                          
                                  
                                          
                                     
                            </div>
              </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
              document.addEventListener('DOMContentLoaded', function() {
                            
                            // Mobile menu functionality
                            const menuBtn = document.getElementById('menu-btn');
                            const sidebar = document.getElementById('sidebar');
                            const overlay = document.getElementById('overlay');
                            const content = document.getElementById('content');
                            
                            if (menuBtn) {
                                          menuBtn.addEventListener('click', function() {
                                                        sidebar.classList.toggle('-translate-x-full');
                                                        overlay.classList.toggle('hidden');
                                          });
                            }
                            
                            if (overlay) {
                                          overlay.addEventListener('click', function() {
                                                        sidebar.classList.add('-translate-x-full');
                                                        overlay.classList.add('hidden');
                                          });
                            }
              });
</script>
@endsection