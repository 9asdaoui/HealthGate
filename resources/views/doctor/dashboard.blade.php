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
                                          
                                          <!-- Recent Patient Health Metrics Chart -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <div class="flex justify-between items-center mb-6">
                                                                      <h3 class="text-lg font-bold text-gray-800">Recent Health Metrics</h3>
                                                                      <div class="flex space-x-2">
                                                                                    <button class="text-sm px-3 py-1 bg-blue-100 text-blue-700 rounded-md active-metric" id="bp-btn">Blood Pressure</button>
                                                                                    <button class="text-sm px-3 py-1 hover:bg-gray-100 text-gray-600 rounded-md" id="bs-btn">Blood Sugar</button>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="chart-container" id="bp-chart">
                                                                      <canvas id="bloodPressureChart"></canvas>
                                                        </div>
                                                        
                                                        <div class="chart-container hidden" id="bs-chart">
                                                                      <canvas id="bloodSugarChart"></canvas>
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
                                          
                                          <!-- Recent Disease Cases -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4">Common Diseases</h3>
                                                        
                                                        @php
                                                                      $commonDiseases = \App\Models\Disease::withCount(['patients' => function($query) use ($user) {
                                                                                    $query->whereHas('appointments', function($q) use ($user) {
                                                                                                  $q->where('doctor_id', $user->doctor->id ?? 0);
                                                                                    });
                                                                      }])
                                                                      ->orderBy('patients_count', 'desc')
                                                                      ->take(5)
                                                                      ->get();
                                                        @endphp
                                                        
                                                        @forelse($commonDiseases as $disease)
                                                                      <div class="flex items-center py-2">
                                                                                    <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
                                                                                    <span class="flex-1 text-gray-700">{{ $disease->name }}</span>
                                                                                    <span class="font-medium text-gray-900">{{ $disease->patients_count }}</span>
                                                                      </div>
                                                        @empty
                                                                      <p class="text-gray-500 text-center py-4">No disease data available</p>
                                                        @endforelse
                                                        
                                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                                                      <a href="{{ route('doctor.diseases') }}" class="text-blue-600 text-sm hover:underline flex items-center justify-center">
                                                                                    <i class="fas fa-disease mr-2"></i> View disease library
                                                                      </a>
                                                        </div>
                                          </div>
                                          
                                          <!-- Recent Medical Records -->
                                          <div class="bg-white rounded-xl shadow-md p-6">
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Medical Records</h3>
                                                        
                                                        @php
                                                                      $recentMedicals = \App\Models\Medical::with('patient.user')
                                                                                    ->where('doctor_id', $user->doctor->id ?? 0)
                                                                                    ->latest()
                                                                                    ->take(3)
                                                                                    ->get();
                                                        @endphp
                                                        
                                                        <div class="space-y-3">
                                                                      @forelse($recentMedicals as $medical)
                                                                                    <div class="flex items-center p-2 border-l-4 border-green-500 bg-green-50 rounded-r-lg">
                                                                                                  <div class="ml-2">
                                                                                                                <h4 class="font-medium text-gray-900">{{ $medical->name }}</h4>
                                                                                                                <p class="text-xs text-gray-500">
                                                                                                                              {{ $medical->patient->user->first_name }} {{ $medical->patient->user->last_name }} • 
                                                                                                                              {{ $medical->created_at->diffForHumans() }}
                                                                                                                </p>
                                                                                                  </div>
                                                                                    </div>
                                                                      @empty
                                                                                    <p class="text-gray-500 text-center py-4">No recent medical records</p>
                                                                      @endforelse
                                                        </div>
                                                        
                                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                                                      <a href="{{ route('doctor.medical-records') }}" class="text-blue-600 text-sm hover:underline flex items-center justify-center">
                                                                                    <i class="fas fa-file-medical mr-2"></i> View all medical records
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
                            // Toggle between BP and BS charts
                            const bpBtn = document.getElementById('bp-btn');
                            const bsBtn = document.getElementById('bs-btn');
                            const bpChart = document.getElementById('bp-chart');
                            const bsChart = document.getElementById('bs-chart');
                            
                            bpBtn.addEventListener('click', function() {
                                          bpChart.classList.remove('hidden');
                                          bsChart.classList.add('hidden');
                                          bpBtn.classList.add('bg-blue-100', 'text-blue-700');
                                          bpBtn.classList.remove('hover:bg-gray-100', 'text-gray-600');
                                          bsBtn.classList.remove('bg-blue-100', 'text-blue-700');
                                          bsBtn.classList.add('hover:bg-gray-100', 'text-gray-600');
                            });
                            
                            bsBtn.addEventListener('click', function() {
                                          bpChart.classList.add('hidden');
                                          bsChart.classList.remove('hidden');
                                          bsBtn.classList.add('bg-blue-100', 'text-blue-700');
                                          bsBtn.classList.remove('hover:bg-gray-100', 'text-gray-600');
                                          bpBtn.classList.remove('bg-blue-100', 'text-blue-700');
                                          bpBtn.classList.add('hover:bg-gray-100', 'text-gray-600');
                            });
                            
                            // Sample blood pressure data for chart
                            const bpCtx = document.getElementById('bloodPressureChart').getContext('2d');
                            new Chart(bpCtx, {
                                          type: 'line',
                                          data: {
                                                        labels: ['Last Week', '6 Days Ago', '5 Days Ago', '4 Days Ago', '3 Days Ago', '2 Days Ago', 'Yesterday'],
                                                        datasets: [
                                                                      {
                                                                                    label: 'Systolic',
                                                                                    data: [120, 118, 125, 117, 122, 119, 121],
                                                                                    borderColor: 'rgb(239, 68, 68)',
                                                                                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                                                                    tension: 0.3,
                                                                                    fill: true
                                                                      },
                                                                      {
                                                                                    label: 'Diastolic',
                                                                                    data: [80, 78, 82, 79, 81, 80, 81],
                                                                                    borderColor: 'rgb(59, 130, 246)',
                                                                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                                                                    tension: 0.3,
                                                                                    fill: true
                                                                      }
                                                        ]
                                          },
                                          options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: {
                                                                      title: {
                                                                                    display: true,
                                                                                    text: 'Patient Blood Pressure Trends'
                                                                      },
                                                                      tooltip: {
                                                                                    mode: 'index',
                                                                                    intersect: false
                                                                      }
                                                        },
                                                        scales: {
                                                                      y: {
                                                                                    min: 60,
                                                                                    max: 140,
                                                                                    title: {
                                                                                                  display: true,
                                                                                                  text: 'mmHg'
                                                                                    }
                                                                      }
                                                        }
                                          }
                            });
                            
                            // Sample blood sugar data for chart
                            const bsCtx = document.getElementById('bloodSugarChart').getContext('2d');
                            new Chart(bsCtx, {
                                          type: 'line',
                                          data: {
                                                        labels: ['Last Week', '6 Days Ago', '5 Days Ago', '4 Days Ago', '3 Days Ago', '2 Days Ago', 'Yesterday'],
                                                        datasets: [{
                                                                      label: 'Blood Sugar',
                                                                      data: [95, 100, 92, 98, 105, 90, 97],
                                                                      borderColor: 'rgb(16, 185, 129)',
                                                                      backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                                                      tension: 0.3,
                                                                      fill: true
                                                        }]
                                          },
                                          options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: {
                                                                      title: {
                                                                                    display: true,
                                                                                    text: 'Patient Blood Sugar Trends'
                                                                      }
                                                        },
                                                        scales: {
                                                                      y: {
                                                                                    min: 70,
                                                                                    max: 130,
                                                                                    title: {
                                                                                                  display: true,
                                                                                                  text: 'mg/dL'
                                                                                    }
                                                                      }
                                                        }
                                          }
                            });
                            
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