@extends('layouts.patient')

@section('title', 'Patient Dashboard')

@section('page-title', 'Patient Dashboard')

@section('breadcrumb', 'Dashboard')

@section('content')
              <!-- Welcome Banner -->
              <div class="bg-white rounded-xl shadow-card overflow-hidden mb-6">
                            <div class="md:flex">
                                          <div class="p-6 md:flex-1">
                                                        <div class="flex items-center mb-4">
                                                                      <div class="h-12 w-12 rounded-full bg-accent bg-opacity-20 flex items-center justify-center">
                                                                                    <i class="fas fa-user-md text-accent"></i>
                                                                      </div>
                                                               <div class="ml-4">
                                                                                    <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name ?? 'User' }}!</h1>
                                                                                    <p class="text-gray-600">Last login: {{ now()->format('M d, Y | h:i A') }}</p>
                                                                      </div>
                                                        </div>
                                                        <p class="text-gray-600 mb-4">Your health dashboard provides a snapshot of your medical information, upcoming appointments, and recent activities.</p>
                                                        <div class="flex flex-wrap gap-3">
                                                                      <a href="" class="bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg inline-flex items-center text-sm font-medium transition-all">
                                                                                    <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
                                                                      </a>
                                                                      <a href="" class="bg-white border border-accent text-accent hover:bg-accent hover:text-white px-4 py-2 rounded-lg inline-flex items-center text-sm font-medium transition-all">
                                                                                    <i class="fas fa-file-medical mr-2"></i> View Medical Records
                                                                      </a>
                                                        </div>
                                          </div>
                                          <div class="hidden md:block w-1/3 bg-gradient-to-r from-accent to-darkTeal p-6 text-white">
                                                        <div class="flex items-center space-x-2 mb-4">
                                                                      <i class="fas fa-heartbeat text-2xl"></i>
                                                                      <h2 class="text-xl font-semibold">Health Tips</h2>
                                                        </div>
                                                        <p class="mb-4 text-sm">Remember to stay hydrated and take regular breaks when working at your computer. Your eye health matters!</p>
                                                        <div class="text-xs bg-white bg-opacity-20 p-3 rounded-lg">
                                                                      <p>"The greatest wealth is health." - Virgil</p>
                                                        </div>
                                          </div>
                            </div>
              </div>

              <!-- Health Stats & Quick Actions -->
              <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                            <!-- Health Stats -->
                            <div class="md:col-span-8 space-y-6">
                                          <!-- Stats Cards -->
                                          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                                        <div class="bg-white rounded-xl p-5 shadow-card card">
                                                                      <div class="flex justify-between items-start">
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Upcoming Appointments</p>
                                                                                                  <h3 class="text-2xl font-bold text-gray-800">3</h3>
                                                                                    </div>
                                                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                                                                  <i class="fas fa-calendar-alt text-blue-500"></i>
                                                                                    </div>
                                                                      </div>
                                                                      <div class="mt-4">
                                                                                    <a href="" class="text-xs text-blue-500 hover:underline flex items-center">
                                                                                                  View Details <i class="fas fa-arrow-right ml-1"></i>
                                                                                    </a>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="bg-white rounded-xl p-5 shadow-card card">
                                                                      <div class="flex justify-between items-start">
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Active Prescriptions</p>
                                                                                                  <h3 class="text-2xl font-bold text-gray-800">2</h3>
                                                                                    </div>
                                                                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                                                                  <i class="fas fa-prescription text-green-500"></i>
                                                                                    </div>
                                                                      </div>
                                                                      <div class="mt-4">
                                                                                    <a href="" class="text-xs text-green-500 hover:underline flex items-center">
                                                                                                  View Details <i class="fas fa-arrow-right ml-1"></i>
                                                                                    </a>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="bg-white rounded-xl p-5 shadow-card card">
                                                                      <div class="flex justify-between items-start">
                                                                                    <div>
                                                                                                  <p class="text-sm text-gray-500">Next Check-up</p>
                                                                                                  <h3 class="text-lg font-semibold text-gray-800">{{ now()->addDays(15)->format('M d, Y') }}</h3>
                                                                                    </div>
                                                                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                                                                  <i class="fas fa-stethoscope text-purple-500"></i>
                                                                                    </div>
                                                                      </div>
                                                                      <div class="mt-4">
                                                                                    <a href="" class="text-xs text-purple-500 hover:underline flex items-center">
                                                                                                  Schedule Again <i class="fas fa-arrow-right ml-1"></i>
                                                                                    </a>
                                                                      </div>
                                                        </div>
                                          </div>

                                          <!-- Health Vitals -->
                                          <div class="bg-white rounded-xl p-6 shadow-card card">
                                                        <div class="flex justify-between items-center mb-6">
                                                                      <h2 class="text-lg font-semibold text-gray-800">Your Health Vitals</h2>
                                                                      <a href="" class="text-sm text-accent hover:underline">Update Records</a>
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                                      <!-- Blood Pressure -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 relative overflow-hidden">
                                                                                    <div class="absolute top-0 right-0 h-16 w-16 bg-red-50 rounded-full -mt-8 -mr-8"></div>
                                                                                    <div class="flex items-center mb-3 relative z-10">
                                                                                                  <div class="h-9 w-9 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-heartbeat text-red-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <h3 class="font-medium text-gray-800">Blood Pressure</h3>
                                                                                                                <p class="text-xs text-gray-500">Last updated: {{ now()->subDays(3)->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="text-gray-800">
                                                                                                  <span class="text-2xl font-bold">120/80</span>
                                                                                                  <span class="text-sm text-gray-500 ml-2">mmHg</span>
                                                                                    </div>
                                                                                    <div class="text-xs text-green-500 mt-1 flex items-center">
                                                                                                  <i class="fas fa-check-circle mr-1"></i> Normal Range
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <!-- Weight -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 relative overflow-hidden">
                                                                                    <div class="absolute top-0 right-0 h-16 w-16 bg-blue-50 rounded-full -mt-8 -mr-8"></div>
                                                                                    <div class="flex items-center mb-3 relative z-10">
                                                                                                  <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-weight text-blue-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <h3 class="font-medium text-gray-800">Weight</h3>
                                                                                                                <p class="text-xs text-gray-500">Last updated: {{ now()->subDays(7)->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="text-gray-800">
                                                                                                  <span class="text-2xl font-bold">68</span>
                                                                                                  <span class="text-sm text-gray-500 ml-2">kg</span>
                                                                                    </div>
                                                                                    <div class="text-xs text-green-500 mt-1 flex items-center">
                                                                                                  <i class="fas fa-check-circle mr-1"></i> Healthy Weight
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <!-- Heart Rate -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 relative overflow-hidden">
                                                                                    <div class="absolute top-0 right-0 h-16 w-16 bg-purple-50 rounded-full -mt-8 -mr-8"></div>
                                                                                    <div class="flex items-center mb-3 relative z-10">
                                                                                                  <div class="h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-heart text-purple-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <h3 class="font-medium text-gray-800">Heart Rate</h3>
                                                                                                                <p class="text-xs text-gray-500">Last updated: {{ now()->subDay()->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="text-gray-800">
                                                                                                  <span class="text-2xl font-bold">72</span>
                                                                                                  <span class="text-sm text-gray-500 ml-2">bpm</span>
                                                                                    </div>
                                                                                    <div class="text-xs text-green-500 mt-1 flex items-center">
                                                                                                  <i class="fas fa-check-circle mr-1"></i> Normal Range
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <!-- Glucose Level -->
                                                                      <div class="border border-gray-100 rounded-lg p-4 relative overflow-hidden">
                                                                                    <div class="absolute top-0 right-0 h-16 w-16 bg-amber-50 rounded-full -mt-8 -mr-8"></div>
                                                                                    <div class="flex items-center mb-3 relative z-10">
                                                                                                  <div class="h-9 w-9 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-tint text-amber-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <h3 class="font-medium text-gray-800">Glucose Level</h3>
                                                                                                                <p class="text-xs text-gray-500">Last updated: {{ now()->subDays(5)->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="text-gray-800">
                                                                                                  <span class="text-2xl font-bold">92</span>
                                                                                                  <span class="text-sm text-gray-500 ml-2">mg/dL</span>
                                                                                    </div>
                                                                                    <div class="text-xs text-green-500 mt-1 flex items-center">
                                                                                                  <i class="fas fa-check-circle mr-1"></i> Normal Range
                                                                                    </div>
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>
                            
                            <!-- Quick Actions Sidebar -->
                            <div class="md:col-span-4 space-y-6">
                                          <!-- Next Appointment -->
                                          <div class="bg-white rounded-xl p-6 shadow-card card">
                                                        <div class="flex justify-between items-center mb-4">
                                                                      <h2 class="text-lg font-semibold text-gray-800">Next Appointment</h2>
                                                        </div>
                                                        <div class="flex items-center p-3 bg-blue-50 rounded-lg mb-4">
                                                                      <div class="bg-accent h-12 w-12 rounded-lg flex items-center justify-center text-white mr-4">
                                                                                    <i class="fas fa-calendar-day"></i>
                                                                      </div>
                                                                      <div>
                                                                                    <p class="text-gray-800 font-medium">Dr. Sarah Johnson</p>
                                                                                    <p class="text-sm text-gray-600">{{ now()->addDays(3)->format('D, M d') }} | 10:30 AM</p>
                                                                      </div>
                                                        </div>
                                                        <div class="flex space-x-2">
                                                                      <a href="" class="flex-1 text-center bg-accent hover:bg-accentHover text-white py-2 px-3 rounded-lg text-sm transition-all">
                                                                                    <i class="fas fa-video mr-1"></i> Join Online
                                                                      </a>
                                                                      <a href="" class="flex-1 text-center border border-gray-300 hover:bg-gray-100 text-gray-800 py-2 px-3 rounded-lg text-sm transition-all">
                                                                                    <i class="fas fa-calendar-alt mr-1"></i> Reschedule
                                                                      </a>
                                                        </div>
                                          </div>
                                          
                                          <!-- Quick Actions -->
                                          <div class="bg-white rounded-xl p-6 shadow-card card">
                                                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
                                                        <div class="space-y-3">
                                                                      <a href="" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                                                                                    <div class="bg-blue-100 h-10 w-10 rounded-lg flex items-center justify-center text-blue-500 mr-3">
                                                                                                  <i class="fas fa-calendar-plus"></i>
                                                                                    </div>
                                                                                    <span class="text-gray-700">Book New Appointment</span>
                                                                      </a>
                                                                      
                                                                      <a href="" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                                                                                    <div class="bg-green-100 h-10 w-10 rounded-lg flex items-center justify-center text-green-500 mr-3">
                                                                                                  <i class="fas fa-prescription"></i>
                                                                                    </div>
                                                                                    <span class="text-gray-700">Request Prescription Renewal</span>
                                                                      </a>
                                                                      
                                                                      <a href="" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                                                                                    <div class="bg-purple-100 h-10 w-10 rounded-lg flex items-center justify-center text-purple-500 mr-3">
                                                                                                  <i class="fas fa-file-medical"></i>
                                                                                    </div>
                                                                                    <span class="text-gray-700">View Test Results</span>
                                                                      </a>
                                                                      
                                                                      <a href="" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                                                                                    <div class="bg-amber-100 h-10 w-10 rounded-lg flex items-center justify-center text-amber-500 mr-3">
                                                                                                  <i class="fas fa-comment-medical"></i>
                                                                                    </div>
                                                                                    <span class="text-gray-700">Message Your Doctor</span>
                                                                      </a>
                                                        </div>
                                          </div>
                                          
                                          <!-- Health Tips -->
                                          <div class="bg-gradient-to-br from-accent/90 to-darkTeal text-white rounded-xl p-6 shadow-card">
                                                        <div class="flex justify-between items-center mb-4">
                                                                      <h2 class="text-lg font-semibold">Daily Health Tip</h2>
                                                                      <i class="fas fa-lightbulb"></i>
                                                        </div>
                                                        <p class="mb-4 text-sm">Regular exercise helps improve your heart health, maintain a healthy weight, and boost your mental well-being.</p>
                                                        <div class="text-xs bg-white/20 p-3 rounded-lg">
                                                                      <p class="font-medium">Tip of the day:</p> 
                                                                      <p>Try to get at least 30 minutes of moderate exercise 5 times a week.</p>
                                                        </div>
                                          </div>
                            </div>
              </div>

              <!-- Recent Medical Records & Upcoming Appointments -->
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Recent Medical Records -->
                            <div class="bg-white rounded-xl p-6 shadow-card card">
                                          <div class="flex justify-between items-center mb-6">
                                                        <h2 class="text-lg font-semibold text-gray-800">Recent Medical Records</h2>
                                                        <a href="" class="text-sm text-accent hover:underline">View All</a>
                                          </div>
                                          <div class="space-y-4">
                                                        <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-all">
                                                                      <div class="flex items-center justify-between">
                                                                                    <div class="flex items-center">
                                                                                                  <div class="bg-purple-100 h-10 w-10 rounded-lg flex items-center justify-center text-purple-500 mr-3">
                                                                                                                <i class="fas fa-file-medical-alt"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="text-gray-800 font-medium">General Check-up</p>
                                                                                                                <p class="text-xs text-gray-500">{{ now()->subDays(14)->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <a href="" class="text-accent hover:underline text-sm">
                                                                                                  <i class="fas fa-eye"></i>
                                                                                    </a>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-all">
                                                                      <div class="flex items-center justify-between">
                                                                                    <div class="flex items-center">
                                                                                                  <div class="bg-blue-100 h-10 w-10 rounded-lg flex items-center justify-center text-blue-500 mr-3">
                                                                                                                <i class="fas fa-microscope"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="text-gray-800 font-medium">Blood Test Results</p>
                                                                                                                <p class="text-xs text-gray-500">{{ now()->subDays(30)->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <a href="" class="text-accent hover:underline text-sm">
                                                                                                  <i class="fas fa-eye"></i>
                                                                                    </a>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-all">
                                                                      <div class="flex items-center justify-between">
                                                                                    <div class="flex items-center">
                                                                                                  <div class="bg-amber-100 h-10 w-10 rounded-lg flex items-center justify-center text-amber-500 mr-3">
                                                                                                                <i class="fas fa-x-ray"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="text-gray-800 font-medium">X-Ray Examination</p>
                                                                                                                <p class="text-xs text-gray-500">{{ now()->subDays(60)->format('M d, Y') }}</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <a href="" class="text-accent hover:underline text-sm">
                                                                                                  <i class="fas fa-eye"></i>
                                                                                    </a>
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>

                            <!-- Upcoming Appointments -->
                            <div class="bg-white rounded-xl p-6 shadow-card card">
                                          <div class="flex justify-between items-center mb-6">
                                                        <h2 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h2>
                                                        <a href="" class="text-sm text-accent hover:underline">View All</a>
                                          </div>
                                          <div class="space-y-4">
                                                        <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-all">
                                                                      <div class="flex items-center justify-between">
                                                                                    <div class="flex items-center">
                                                                                                  <div class="bg-accent h-10 w-10 rounded-lg flex items-center justify-center text-white mr-3">
                                                                                                                <i class="fas fa-user-md"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="text-gray-800 font-medium">Dr. Sarah Johnson</p>
                                                                                                                <p class="text-xs text-gray-500">{{ now()->addDays(3)->format('M d, Y') }} | 10:30 AM | Cardiology</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="flex space-x-2">
                                                                                                  <a href="" class="text-blue-500 hover:bg-blue-100 h-8 w-8 rounded-full flex items-center justify-center">
                                                                                                                <i class="fas fa-video"></i>
                                                                                                  </a>
                                                                                                  <a href="" class="text-red-500 hover:bg-red-100 h-8 w-8 rounded-full flex items-center justify-center">
                                                                                                                <i class="fas fa-times"></i>
                                                                                                  </a>
                                                                                    </div>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-all">
                                                                      <div class="flex items-center justify-between">
                                                                                    <div class="flex items-center">
                                                                                                  <div class="bg-blue-500 h-10 w-10 rounded-lg flex items-center justify-center text-white mr-3">
                                                                                                                <i class="fas fa-user-md"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="text-gray-800 font-medium">Dr. Michael Chen</p>
                                                                                                                <p class="text-xs text-gray-500">{{ now()->addDays(7)->format('M d, Y') }} | 2:00 PM | Ophthalmology</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="flex space-x-2">
                                                                                                  <a href="" class="text-blue-500 hover:bg-blue-100 h-8 w-8 rounded-full flex items-center justify-center">
                                                                                                                <i class="fas fa-video"></i>
                                                                                                  </a>
                                                                                                  <a href="" class="text-red-500 hover:bg-red-100 h-8 w-8 rounded-full flex items-center justify-center">
                                                                                                                <i class="fas fa-times"></i>
                                                                                                  </a>
                                                                                    </div>
                                                                      </div>
                                                        </div>
                                                        
                                                        <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-all">
                                                                      <div class="flex items-center justify-between">
                                                                                    <div class="flex items-center">
                                                                                                  <div class="bg-purple-500 h-10 w-10 rounded-lg flex items-center justify-center text-white mr-3">
                                                                                                                <i class="fas fa-user-md"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="text-gray-800 font-medium">Dr. Emily Rodriguez</p>
                                                                                                                <p class="text-xs text-gray-500">{{ now()->addDays(15)->format('M d, Y') }} | 9:15 AM | General</p>
                                                                                                  </div>
                                                                                    </div>
                                                                                    <div class="flex space-x-2">
                                                                                                  <a href="" class="text-blue-500 hover:bg-blue-100 h-8 w-8 rounded-full flex items-center justify-center">
                                                                                                                <i class="fas fa-video"></i>
                                                                                                  </a>
                                                                                                  <a href="" class="text-red-500 hover:bg-red-100 h-8 w-8 rounded-full flex items-center justify-center">
                                                                                                                <i class="fas fa-times"></i>
                                                                                                  </a>
                                                                                    </div>
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>
              </div>

              <!-- Medications Schedule -->
              <div class="bg-white rounded-xl p-6 shadow-card card mb-6">
                            <div class="flex justify-between items-center mb-6">
                                          <h2 class="text-lg font-semibold text-gray-800">Medications Schedule</h2>
                                          <a href="" class="text-sm text-accent hover:underline">View All</a>
                            </div>
                            <div class="overflow-x-auto">
                                          <table class="min-w-full bg-white">
                                                        <thead class="bg-gray-50 text-gray-600 text-sm">
                                                                      <tr>
                                                                                    <th class="py-3 px-4 text-left rounded-tl-lg">Medication</th>
                                                                                    <th class="py-3 px-4 text-left">Dosage</th>
                                                                                    <th class="py-3 px-4 text-left">Schedule</th>
                                                                                    <th class="py-3 px-4 text-left">Duration</th>
                                                                                    <th class="py-3 px-4 text-left rounded-tr-lg">Status</th>
                                                                      </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                                                                      <tr class="hover:bg-gray-50">
                                                                                    <td class="py-3 px-4 flex items-center">
                                                                                                  <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-pills text-blue-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="font-medium">Amoxicillin</p>
                                                                                                                <p class="text-xs text-gray-500">Antibiotic</p>
                                                                                                  </div>
                                                                                    </td>
                                                                                    <td class="py-3 px-4">500mg</td>
                                                                                    <td class="py-3 px-4">3 times daily</td>
                                                                                    <td class="py-3 px-4">7 days</td>
                                                                                    <td class="py-3 px-4">
                                                                                                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                                                                                    </td>
                                                                      </tr>
                                                                      <tr class="hover:bg-gray-50">
                                                                                    <td class="py-3 px-4 flex items-center">
                                                                                                  <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-capsules text-purple-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="font-medium">Ibuprofen</p>
                                                                                                                <p class="text-xs text-gray-500">Pain Relief</p>
                                                                                                  </div>
                                                                                    </td>
                                                                                    <td class="py-3 px-4">400mg</td>
                                                                                    <td class="py-3 px-4">As needed</td>
                                                                                    <td class="py-3 px-4">10 days</td>
                                                                                    <td class="py-3 px-4">
                                                                                                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                                                                                    </td>
                                                                      </tr>
                                                                      <tr class="hover:bg-gray-50">
                                                                                    <td class="py-3 px-4 flex items-center">
                                                                                                  <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                                                                                                <i class="fas fa-tablets text-amber-500"></i>
                                                                                                  </div>
                                                                                                  <div>
                                                                                                                <p class="font-medium">Lisinopril</p>
                                                                                                                <p class="text-xs text-gray-500">Blood Pressure</p>
                                                                                                  </div>
                                                                                    </td>
                                                                                    <td class="py-3 px-4">10mg</td>
                                                                                    <td class="py-3 px-4">Once daily</td>
                                                                                    <td class="py-3 px-4">30 days</td>
                                                                                    <td class="py-3 px-4">
                                                                                                  <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">Completed</span>
                                                                                    </td>
                                                                      </tr>
                                                        </tbody>
                                          </table>
                            </div>
              </div>
@endsection

@section('scripts')
<script>
              // Add card animation class to all cards
              document.addEventListener('DOMContentLoaded', function() {
                            const cards = document.querySelectorAll('.card');
                            cards.forEach(card => {
                                          card.classList.add('card-animate');
                            });
              });
</script>
@endsection