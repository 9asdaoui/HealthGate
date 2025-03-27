@extends('layouts.patient')

@section('title', 'Schedule Appointment')

@section('page-title', 'Schedule Appointment')

@section('breadcrumb', 'Appointments')

@section('content')
<div class="space-y-6">
              <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div>
                                          <h2 class="text-2xl font-semibold text-gray-800">Schedule New Appointment</h2>
                                          <p class="text-gray-500 mt-1">Find a doctor and book your appointment</p>
                            </div>
                            <a href="{{ route('patient.appointments') }}" class="mt-4 md:mt-0 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                                          <i class="fas fa-arrow-left mr-2"></i> Back to Appointments
                            </a>
              </div>
              
              <!-- Filters -->
              <div class="bg-white rounded-xl shadow-md p-6">
                            <form action="{{ route('patient.appointments.create') }}" method="GET" class="space-y-4">
                                          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div>
                                                                      <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                                                      <select id="department" name="department" class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent">
                                                                                    <option value="">All Departments</option>
                                                                                    @foreach($departments as $department)
                                                                                                  <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                                                                                                {{ $department->name }}
                                                                                                  </option>
                                                                                    @endforeach
                                                                      </select>
                                                        </div>
                                                        
                                                        <div>
                                                                      <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Doctor Name</label>
                                                                      <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by name..." 
                                                                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent">
                                                        </div>
                                                        
                                                        <div class="flex items-end">
                                                                      <button type="submit" class="bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg transition-colors">
                                                                                    <i class="fas fa-filter mr-2"></i> Filter Results
                                                                      </button>
                                                        </div>
                                          </div>
                            </form>
              </div>
              
              <!-- Doctors List -->
              <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                          <h3 class="text-lg font-medium text-gray-800">Available Doctors</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                                          @forelse($doctors as $doctor)
                                          <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                                        <div class="p-5">
                                                                      <div class="flex items-center space-x-4">
                                                                                    <div class="flex-shrink-0">
                                                                                                  <img class="h-16 w-16 rounded-full object-cover border-2 border-accent" 
                                                                                                                 src="{{ $user->image ?? asset('images/default-doctor.png') }}" 
                                                                                                                 alt="Dr. {{ $user->first_name }} {{ $user->last_name }}">
                                                                                    </div>
                                                                                    <div class="flex-1 min-w-0">
                                                                                                  <p class="text-lg font-medium text-gray-900 truncate">
                                                                                                                Dr. {{ $user->first_name }} {{ $user->last_name }}
                                                                                                  </p>
                                                                                                  <p class="text-sm text-gray-500">
                                                                                                                {{ $doctor->speciality ?? 'General Practitioner' }}
                                                                                                  </p>
                                                                                                  <p class="text-sm text-gray-500">
                                                                                                                <i class="fas fa-hospital-alt mr-1 text-accent"></i>
                                                                                                                {{ $doctor->department->name ?? 'General Department' }}
                                                                                                  </p>
                                                                                    </div>
                                                                      </div>
                                                                      
                                                                      <div class="mt-4 flex justify-between items-center">
                                                                                    <button type="button" 
                                                                                                                onclick="openScheduleModal({{ $doctor->id }})" 
                                                                                                                class="bg-accent hover:bg-accentHover text-white px-3 py-1 rounded text-sm transition-colors">
                                                                                                  <i class="fas fa-calendar-plus mr-1"></i> Schedule
                                                                                    </button>
                                                                      </div>
                                                        </div>
                                          </div>
                                          @empty
                                          <div class="col-span-3 py-12 text-center text-gray-500">
                                                        <i class="fas fa-user-md text-4xl mb-3"></i>
                                                        <p>No doctors found matching your criteria</p>
                                                        <a href="{{ route('patient.appointments.create') }}" class="mt-3 text-accent hover:underline inline-flex items-center">
                                                                      <i class="fas fa-sync-alt mr-2"></i> Reset Filters
                                                        </a>
                                          </div>
                                          @endforelse
                            </div>
                            
                            <div class="px-6 py-4">
                                          {{ $doctors->links() }}
                            </div>
              </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
              <div class="bg-white rounded-lg max-w-md w-full max-h-screen overflow-y-auto">
                            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                                          <h3 class="text-lg font-medium text-gray-800">Schedule Appointment</h3>
                                          <button type="button" onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-500">
                                                        <i class="fas fa-times"></i>
                                          </button>
                            </div>
                            
                            <form id="appointmentForm" action="{{ route('patient.appointments.store') }}" method="POST" class="p-6 space-y-4">
                                          @csrf
                                          <input type="hidden" id="doctor_id" name="doctor_id">
                                          
                                          <div>
                                                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Select Date</label>
                                                        <input type="date" id="appointment_date" name="appointment_date" required
                                                                         min="{{ date('Y-m-d') }}" 
                                                                         class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent">
                                          </div>
                                          
                                          <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Available Time Slots</label>
                                                        <div id="timeSlots" class="grid grid-cols-3 gap-2">
                                                                      <p class="col-span-3 text-gray-500 text-center py-4">
                                                                                    Select a date to view available time slots
                                                                      </p>
                                                        </div>
                                          </div>
                                          
                                          <div>
                                                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
                                                        <textarea id="reason" name="reason" rows="3" required
                                                                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent"
                                                                                      placeholder="Briefly describe your symptoms or reason for the appointment"></textarea>
                                          </div>
                                          
                                          <div class="mt-6">
                                                        <button type="submit" class="w-full bg-accent hover:bg-accentHover text-white py-2 px-4 rounded-lg transition-colors">
                                                                      Confirm Appointment
                                                        </button>
                                          </div>
                            </form>
              </div>
</div>
@endsection

@section('scripts')
<script>
              function openScheduleModal(doctorId) {
                            document.getElementById('doctor_id').value = doctorId;
                            document.getElementById('scheduleModal').classList.remove('hidden');
                            document.body.classList.add('overflow-hidden');
              }
              
              function closeScheduleModal() {
                            document.getElementById('scheduleModal').classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
              }
              
              document.getElementById('appointment_date').addEventListener('change', async function() {
                            const date = this.value;
                            const doctorId = document.getElementById('doctor_id').value;
                            const timeSlotsContainer = document.getElementById('timeSlots');
                            // loading
                            timeSlotsContainer.innerHTML = '<p class="col-span-3 text-center py-4">Loading available slots...</p>';
                            try {
                                          response = await fetch(`/api/getSlots`,
                                          {
                                                        method: 'POST',
                                                        headers: {
                                                                      'Content-Type': 'application/json',
                                                                      'Accept': 'application/json',
                                                        },
                                                        body: JSON.stringify({
                                                                      date: date,
                                                                      doctor_id: doctorId
                                                        })
                                          }
                                          );
                                          if (!response.ok) {
                                                        throw new Error('Network response was not ok');
                                          }
                                          const data = await response.json();
                                          console.log(data);
                                          const timeSlots = data['available_slots'];
                                          
                                          let html = '';
                                          if (timeSlots.length > 0) {
                                                        timeSlots.forEach(slot => {
                                                                      html += `
                                                                                    <label class="border rounded-md p-2 text-center cursor-pointer hover:bg-gray-50">
                                                                                                  <input type="radio" name="" value="${slot}" class="sr-only" required>
                                                                                                   <span class="text-sm">${slot}</span>
                                                                                    </label>
                                                                      `;
                                                        });
                                          } else {
                                                        html = '<p class="col-span-3 text-center py-4">No available slots for this date</p>';
                                          }
                                          
                                          timeSlotsContainer.innerHTML = html;
                                          
                                            // Add click event to highlight selected time slot and update a hidden input
                                            const slotLabels = timeSlotsContainer.querySelectorAll('label');
                                            slotLabels.forEach(label => {
                                                                                                  const radioInput = label.querySelector('input[type="radio"]');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                                                                                                  label.addEventListener('click', function() {
                                                                                                                                              // Remove highlight from all slots and reset names
                                                                                                                                              slotLabels.forEach(l => {
                                                                                                                                                                                                    l.classList.remove('bg-accent', 'text-white');
                                                                                                                                                                                                    l.querySelector('input[type="radio"]').name = "";
                                                                                                                                              });
                                                                                                                                              
                                                                                                                                              // Highlight this slot
                                                                                                                                              this.classList.add('bg-accent', 'text-white');
                                                                                                                                              
                                                                                                                                              // Set the name only on the clicked input
                                                                                                                                              radioInput.name = "time_slot";
                                                                                                                                              radioInput.checked = true;
                                                                                                  });
                                            });


                            }
                            catch (error) {
                                          console.log(error);
                            }

              
                                          
                                          
                                         
              });
              
              // Close modal when clicking outside
              window.addEventListener('click', function(event) {
                            const modal = document.getElementById('scheduleModal');
                            if (event.target === modal) {
                                          closeScheduleModal();
                            }
              });
</script>
@endsection