@extends('layouts.doctor')

@section('title', 'Dashboard')

@section('styles')
<style>
              .stats-card {
                            transition: all 0.3s ease;
              }
              .stats-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
              }
              .chart-container {
                            height: 300px;
                            position: relative;
              }
              .calendar-container {
                            min-height: 320px;
              }
</style>
@endsection

@section('content')
<div class="p-6 space-y-6">
              <!-- Welcome Banner -->
              <div class="bg-gradient-to-r from-secondary to-primary rounded-xl shadow-lg p-6 text-white flex justify-between items-center">
                            <div>
                                          <h1 class="text-2xl font-bold">Welcome Back, Dr. {{ Auth::user()->name }}!</h1>
                                          <p class="mt-1 opacity-90">{{ now()->format('l, F j, Y') }}</p>
                            </div>
                            <div class="hidden md:block">
                                          <img src="{{ asset('images/doctor-illustration.svg') }}" alt="Doctor" class="h-24">
                            </div>
              </div>

              <!-- Stats Overview -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="bg-white rounded-xl shadow p-6 stats-card flex items-center">
                                          <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                                                        <i class="fas fa-calendar-check text-xl"></i>
                                          </div>
                                          <div>
                                                        <p class="text-sm text-gray-500">Today's Appointments</p>
                                                        <h3 class="text-2xl font-bold">{{ $todayAppointments ?? 0 }}</h3>
                                          </div>
                            </div>
                            
                            <div class="bg-white rounded-xl shadow p-6 stats-card flex items-center">
                                          <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                                                        <i class="fas fa-user-plus text-xl"></i>
                                          </div>
                                          <div>
                                                        <p class="text-sm text-gray-500">Total Patients</p>
                                                        <h3 class="text-2xl font-bold">{{ $totalPatients ?? 0 }}</h3>
                                          </div>
                            </div>
                            
                            <div class="bg-white rounded-xl shadow p-6 stats-card flex items-center">
                                          <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                                                        <i class="fas fa-pills text-xl"></i>
                                          </div>
                                          <div>
                                                        <p class="text-sm text-gray-500">Prescriptions</p>
                                                        <h3 class="text-2xl font-bold">{{ $totalPrescriptions ?? 0 }}</h3>
                                          </div>
                            </div>
                            
                            <div class="bg-white rounded-xl shadow p-6 stats-card flex items-center">
                                          <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                                                        <i class="fas fa-notes-medical text-xl"></i>
                                          </div>
                                          <div>
                                                        <p class="text-sm text-gray-500">Medical Records</p>
                                                        <h3 class="text-2xl font-bold">{{ $totalMedicalRecords ?? 0 }}</h3>
                                          </div>
                            </div>
              </div>

              <!-- Appointments and Analytics Section -->
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Today's Appointments -->
                            <div class="bg-white rounded-xl shadow">
                                          <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                                                        <h2 class="font-semibold text-lg text-gray-700">Today's Appointments</h2>
                                                        <a href="" class="text-sm text-primary hover:underline">View All</a>
                                          </div>
                                          <div class="p-4 overflow-auto max-h-80">
                                                        @if(isset($appointments) && count($appointments) > 0)
                                                                      <div class="space-y-4">
                                                                                    @foreach($appointments as $appointment)
                                                                                                  <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                                                                                                <div class="flex items-center">
                                                                                                                              <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center mr-3">
                                                                                                                                            <span class="font-medium">{{ substr($appointment->patient->user->name ?? 'P', 0, 1) }}</span>
                                                                                                                              </div>
                                                                                                                              <div>
                                                                                                                                            <p class="font-medium">{{ $appointment->patient->user->name ?? 'Patient' }}</p>
                                                                                                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                                                                                                                              </div>
                                                                                                                </div>
                                                                                                                <div class="text-right">
                                                                                                                              <span class="px-2 py-1 rounded text-xs 
                                                                                                                                            @if($appointment->status == 'scheduled') bg-blue-100 text-blue-700
                                                                                                                                            @elseif($appointment->status == 'completed') bg-green-100 text-green-700
                                                                                                                                            @elseif($appointment->status == 'cancelled') bg-red-100 text-red-700
                                                                                                                                            @else bg-gray-100 text-gray-700 @endif">
                                                                                                                                            {{ ucfirst($appointment->status) }}
                                                                                                                              </span>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    @endforeach
                                                                      </div>
                                                        @else
                                                                      <div class="text-center py-6">
                                                                                    <div class="text-gray-400 mb-2"><i class="far fa-calendar-times text-3xl"></i></div>
                                                                                    <p class="text-gray-500">No appointments scheduled for today</p>
                                                                      </div>
                                                        @endif
                                          </div>
                            </div>

                            <!-- Patient Demographics -->
                            <div class="bg-white rounded-xl shadow">
                                          <div class="p-4 border-b border-gray-100">
                                                        <h2 class="font-semibold text-lg text-gray-700">Patient Demographics</h2>
                                          </div>
                                          <div class="p-4 chart-container">
                                                        <canvas id="patientDemographicsChart"></canvas>
                                          </div>
                            </div>
              </div>

              <!-- Recent Patients & Calendar Section -->
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Recent Patients -->
                            <div class="bg-white rounded-xl shadow">
                                          <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                                                        <h2 class="font-semibold text-lg text-gray-700">Recent Patients</h2>
                                                        <a href=" class="text-sm text-primary hover:underline">View All</a>
                                          </div>
                                          <div class="p-4 overflow-auto max-h-80">
                                                        @if(isset($recentPatients) && count($recentPatients) > 0)
                                                                      <div class="divide-y divide-gray-100">
                                                                                    @foreach($recentPatients as $patient)
                                                                                                  <div class="flex justify-between items-center py-3">
                                                                                                                <div class="flex items-center">
                                                                                                                              <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                                                                                                            <span class="text-gray-600 font-medium">{{ substr($patient->user->name ?? 'P', 0, 1) }}</span>
                                                                                                                              </div>
                                                                                                                              <div>
                                                                                                                                            <p class="font-medium">{{ $patient->user->name }}</p>
                                                                                                                                            <p class="text-xs text-gray-500">Last visit: {{ \Carbon\Carbon::parse($patient->updated_at)->diffForHumans() }}</p>
                                                                                                                              </div>
                                                                                                                </div>
                                                                                                                <a href="" class="text-primary hover:text-primary-dark">
                                                                                                                              <i class="fas fa-chevron-right"></i>
                                                                                                                </a>
                                                                                                  </div>
                                                                                    @endforeach
                                                                      </div>
                                                        @else
                                                                      <div class="text-center py-6">
                                                                                    <div class="text-gray-400 mb-2"><i class="far fa-user-circle text-3xl"></i></div>
                                                                                    <p class="text-gray-500">No recent patients</p>
                                                                      </div>
                                                        @endif
                                          </div>
                            </div>

                            <!-- Calendar / Upcoming Appointments -->
                            <div class="bg-white rounded-xl shadow">
                                          <div class="p-4 border-b border-gray-100">
                                                        <h2 class="font-semibold text-lg text-gray-700">Calendar</h2>
                                          </div>
                                          <div class="p-4 calendar-container">
                                                        <div id="calendar"></div>
                                          </div>
                            </div>
              </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">

<script>
              // Patient Demographics Chart
              document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('patientDemographicsChart').getContext('2d');
                            
                            const demographicsChart = new Chart(ctx, {
                                          type: 'doughnut',
                                          data: {
                                                        labels: ['Male', 'Female', 'Other'],
                                                        datasets: [{
                                                                      label: 'Patient Gender Distribution',
                                                                      data: [{{ $malePatients ?? 0 }}, {{ $femalePatients ?? 0 }}, {{ $otherPatients ?? 0 }}],
                                                                      backgroundColor: [
                                                                                    'rgba(54, 162, 235, 0.7)',
                                                                                    'rgba(255, 99, 132, 0.7)',
                                                                                    'rgba(255, 206, 86, 0.7)'
                                                                      ],
                                                                      borderColor: [
                                                                                    'rgba(54, 162, 235, 1)',
                                                                                    'rgba(255, 99, 132, 1)',
                                                                                    'rgba(255, 206, 86, 1)'
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
                                                                      },
                                                                      title: {
                                                                                    display: true,
                                                                                    text: 'Patient Gender Distribution'
                                                                      }
                                                        }
                                          }
                            });

                            // Initialize Calendar
                            const calendarEl = document.getElementById('calendar');
                            const calendar = new FullCalendar.Calendar(calendarEl, {
                                          initialView: 'dayGridMonth',
                                          headerToolbar: {
                                                        left: 'prev,next today',
                                                        center: 'title',
                                                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                                          },
                                          height: 'auto',
                                          events: [
                                                        // You can populate this with appointment data from backend
                                                        // Example format:
                                                        // { title: 'Patient Name', start: '2023-05-05T10:00:00', end: '2023-05-05T11:00:00' }
                                                        @if(isset($calendarEvents))
                                                                      @foreach($calendarEvents as $event)
                                                                                    {
                                                                                                  title: '{{ $event['title'] }}',
                                                                                                  start: '{{ $event['start'] }}',
                                                                                                  end: '{{ $event['end'] }}',
                                                                                                  backgroundColor: '{{ $event['color'] ?? '#00928C' }}'
                                                                                    },
                                                                      @endforeach
                                                        @endif
                                          ],
                                          eventClick: function(info) {
                                                        // Handle event click (optional)
                                                        // alert('Event: ' + info.event.title);
                                          }
                            });
                            calendar.render();
              });
</script>
@endsection