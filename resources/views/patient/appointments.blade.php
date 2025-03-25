@extends('layouts.patient')

@section('title', 'My Appointments')

@section('page-title', 'Appointments')

@section('breadcrumb', 'Appointments')

@section('content')
<div class="space-y-6">
              <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div>
                                          <h2 class="text-2xl font-semibold text-gray-800">My Appointments</h2>
                                          <p class="text-gray-500 mt-1">View and manage your scheduled appointments</p>
                            </div>
                            
                            <button id="new-appointment-btn" class="mt-4 md:mt-0 bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                                          <i class="fas fa-plus-circle mr-2"></i> New Appointment
                            </button>
              </div>
              
              <!-- Appointment Filter Section -->
              <div class="bg-white rounded-xl shadow-card p-6">
                            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                          <div class="flex-1">
                                                        <label for="status-filter" class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                                                        <select id="status-filter" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent">
                                                                      <option value="all">All Appointments</option>
                                                                      <option value="upcoming">Upcoming</option>
                                                                      <option value="completed">Completed</option>
                                                                      <option value="cancelled">Cancelled</option>
                                                        </select>
                                          </div>
                                          
                                          <div class="flex-1">
                                                        <label for="date-range" class="block text-sm font-medium text-gray-500 mb-1">Date Range</label>
                                                        <select id="date-range" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent">
                                                                      <option value="all">All Time</option>
                                                                      <option value="today">Today</option>
                                                                      <option value="week">This Week</option>
                                                                      <option value="month">This Month</option>
                                                                      <option value="custom">Custom Range</option>
                                                        </select>
                                          </div>
                                          
                                          <div class="flex-1">
                                                        <label for="search-doctor" class="block text-sm font-medium text-gray-500 mb-1">Search Doctor</label>
                                                        <input type="text" id="search-doctor" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" placeholder="Doctor name...">
                                          </div>
                            </div>
              </div>
              
              <!-- Appointments List -->
              <div class="bg-white rounded-xl shadow-card overflow-hidden">
                            <div class="overflow-x-auto">
                                          <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                                      <tr>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                                      </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                                      @if(count($appointments ?? []) > 0)
                                                                                    @foreach($appointments as $appointment)
                                                                                    <tr>
                                                                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                                                                                <div class="flex items-center">
                                                                                                                              <div class="flex-shrink-0 h-10 w-10">
                                                                                                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $appointment->doctor->user->image ?? asset('images/default-avatar.jpg') }}" alt="">
                                                                                                                              </div>
                                                                                                                              <div class="ml-4">
                                                                                                                                            <div class="text-sm font-medium text-gray-900">Dr. {{ $appointment->doctor->user->first_name ?? 'Unknown' }} {{ $appointment->doctor->user->last_name ?? '' }}</div>
                                                                                                                                            <div class="text-sm text-gray-500">{{ $appointment->doctor->speciality ?? 'General Practitioner' }}</div>
                                                                                                                              </div>
                                                                                                                </div>
                                                                                                  </td>
                                                                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                                                                                <div class="text-sm text-gray-900">{{ date('M d, Y', strtotime($appointment->appointment_date)) }}</div>
                                                                                                                <div class="text-sm text-gray-500">{{ date('h:i A', strtotime($appointment->appointment_date)) }}</div>
                                                                                                  </td>
                                                                                                  <td class="px-6 py-4 whitespace-nowrap">
                                                                                                                @if($appointment->status == 'upcoming')
                                                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                                                                              Upcoming
                                                                                                                </span>
                                                                                                                @elseif($appointment->status == 'completed')
                                                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                                                              Completed
                                                                                                                </span>
                                                                                                                @elseif($appointment->status == 'cancelled')
                                                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                                                                              Cancelled
                                                                                                                </span>
                                                                                                                @else
                                                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                                                                              {{ ucfirst($appointment->status) }}
                                                                                                                </span>
                                                                                                                @endif
                                                                                                  </td>
                                                                                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                                                                <button class="text-accent hover:text-accentHover mr-3 view-appointment" data-id="{{ $appointment->id }}">
                                                                                                                              <i class="fas fa-eye"></i>
                                                                                                                </button>
                                                                                                                @if($appointment->status == 'upcoming')
                                                                                                                <button class="text-red-600 hover:text-red-800 cancel-appointment" data-id="{{ $appointment->id }}">
                                                                                                                              <i class="fas fa-times-circle"></i>
                                                                                                                </button>
                                                                                                                @endif
                                                                                                  </td>
                                                                                    </tr>
                                                                                    @endforeach
                                                                      @else
                                                                                    <tr>
                                                                                                  <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                                                                                                <i class="fas fa-calendar-times text-4xl mb-3"></i>
                                                                                                                <p>No appointments found</p>
                                                                                                                <button id="empty-new-appointment-btn" class="mt-3 bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                                                                                                              <i class="fas fa-plus-circle mr-2"></i> Schedule New Appointment
                                                                                                                </button>
                                                                                                  </td>
                                                                                    </tr>
                                                                      @endif
                                                        </tbody>
                                          </table>
                            </div>
              </div>
</div>

<!-- New Appointment Modal -->
<div id="new-appointment-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
              <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                            <div class="p-6">
                                          <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-semibold">Schedule New Appointment</h3>
                                                        <button id="close-appointment-modal" class="text-gray-500 hover:text-gray-700">
                                                                      <i class="fas fa-times"></i>
                                                        </button>
                                          </div>
                                          {{-- {{ route('patient.appointment.store') }} --}}
                                          <form action="" method="POST" class="space-y-4">
                                                        @csrf
                                                        <div>
                                                                      <label for="doctor_id" class="block text-sm font-medium text-gray-500 mb-1">Select Doctor</label>
                                                                      <select id="doctor_id" name="doctor_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" required>
                                                                                    <option value="">-- Select a doctor --</option>
                                                                                    @foreach($doctors ?? [] as $doctor)
                                                                                                  <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }} - {{ $doctor->speciality }}</option>
                                                                                    @endforeach
                                                                      </select>
                                                        </div>
                                                        
                                                        <div>
                                                                      <label for="appointment_date" class="block text-sm font-medium text-gray-500 mb-1">Appointment Date</label>
                                                                      <input type="date" id="appointment_date" name="appointment_date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" required min="{{ date('Y-m-d') }}">
                                                        </div>
                                                        
                                                        <div>
                                                                      <label for="appointment_time" class="block text-sm font-medium text-gray-500 mb-1">Appointment Time</label>
                                                                      <select id="appointment_time" name="appointment_time" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" required>
                                                                                    <option value="">-- Select time --</option>
                                                                                    <option value="09:00:00">9:00 AM</option>
                                                                                    <option value="10:00:00">10:00 AM</option>
                                                                                    <option value="11:00:00">11:00 AM</option>
                                                                                    <option value="12:00:00">12:00 PM</option>
                                                                                    <option value="13:00:00">1:00 PM</option>
                                                                                    <option value="14:00:00">2:00 PM</option>
                                                                                    <option value="15:00:00">3:00 PM</option>
                                                                                    <option value="16:00:00">4:00 PM</option>
                                                                      </select>
                                                        </div>
                                                        
                                                        <div>
                                                                      <label for="reason" class="block text-sm font-medium text-gray-500 mb-1">Reason for Visit</label>
                                                                      <textarea id="reason" name="reason" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" placeholder="Briefly describe your symptoms or reason for visit"></textarea>
                                                        </div>
                                                        
                                                        <div class="pt-2">
                                                                      <button type="submit" class="w-full bg-accent hover:bg-accentHover text-white py-2.5 px-4 rounded-lg transition-colors font-medium">
                                                                                    <i class="fas fa-calendar-check mr-2"></i> Schedule Appointment
                                                                      </button>
                                                        </div>
                                          </form>
                            </div>
              </div>
</div>

<!-- View Appointment Modal -->
<div id="view-appointment-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
              <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                            <div class="p-6">
                                          <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-semibold">Appointment Details</h3>
                                                        <button id="close-view-modal" class="text-gray-500 hover:text-gray-700">
                                                                      <i class="fas fa-times"></i>
                                                        </button>
                                          </div>
                                          
                                          <div id="appointment-details" class="space-y-4">
                                                        <!-- This will be populated with AJAX -->
                                                        <div class="text-center py-8">
                                                                      <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-accent"></div>
                                                                      <p class="mt-2 text-gray-500">Loading appointment details...</p>
                                                        </div>
                                          </div>
                                          
                                          <div class="pt-4 border-t border-gray-200 mt-4" id="appointment-actions">
                                                        <!-- Actions will be inserted here based on appointment status -->
                                          </div>
                            </div>
              </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
              // Modal controls for new appointment
              const newAppointmentBtn = document.getElementById('new-appointment-btn');
              const emptyNewAppointmentBtn = document.getElementById('empty-new-appointment-btn');
              const newAppointmentModal = document.getElementById('new-appointment-modal');
              const closeAppointmentModal = document.getElementById('close-appointment-modal');
              
              if(newAppointmentBtn && newAppointmentModal) {
                            newAppointmentBtn.addEventListener('click', function() {
                                          newAppointmentModal.classList.remove('hidden');
                            });
              }
              
              if(emptyNewAppointmentBtn && newAppointmentModal) {
                            emptyNewAppointmentBtn.addEventListener('click', function() {
                                          newAppointmentModal.classList.remove('hidden');
                            });
              }
              
              if(closeAppointmentModal && newAppointmentModal) {
                            closeAppointmentModal.addEventListener('click', function() {
                                          newAppointmentModal.classList.add('hidden');
                            });
              }
              
              // Modal controls for view appointment
              const viewButtons = document.querySelectorAll('.view-appointment');
              const viewAppointmentModal = document.getElementById('view-appointment-modal');
              const closeViewModal = document.getElementById('close-view-modal');
              
              viewButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                          const appointmentId = this.getAttribute('data-id');
                                          // Here you would fetch appointment details with AJAX
                                          // For now we'll just show the modal
                                          viewAppointmentModal.classList.remove('hidden');
                                          
                                          // Example of what the AJAX call might look like:
                                          // fetch(`/api/appointments/${appointmentId}`)
                                          //   .then(response => response.json())
                                          //   .then(data => {
                                          //     document.getElementById('appointment-details').innerHTML = `
                                          //       <div>Details for appointment ${data.id}</div>
                                          //     `;
                                          //   });
                            });
              });
              
              if(closeViewModal && viewAppointmentModal) {
                            closeViewModal.addEventListener('click', function() {
                                          viewAppointmentModal.classList.add('hidden');
                            });
              }
              
              // Cancel appointment functionality
              const cancelButtons = document.querySelectorAll('.cancel-appointment');
              
              cancelButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                          const appointmentId = this.getAttribute('data-id');
                                          if(confirm('Are you sure you want to cancel this appointment?')) {
                                                        // Submit cancellation request
                                                        // Example: window.location.href = `/appointments/${appointmentId}/cancel`;
                                          }
                            });
              });
              
              // Filter functionality
              const statusFilter = document.getElementById('status-filter');
              const dateRange = document.getElementById('date-range');
              const searchDoctor = document.getElementById('search-doctor');
              
              if(statusFilter) {
                            statusFilter.addEventListener('change', filterAppointments);
              }
              
              if(dateRange) {
                            dateRange.addEventListener('change', filterAppointments);
              }
              
              if(searchDoctor) {
                            searchDoctor.addEventListener('input', filterAppointments);
              }
              
              function filterAppointments() {
                            // This would be implemented with either AJAX or client-side filtering
                            console.log('Filtering appointments');
                            // Example: fetch(`/api/appointments?status=${statusFilter.value}&date=${dateRange.value}&doctor=${searchDoctor.value}`)
              }
              
              // Close modals when clicking outside
              window.addEventListener('click', function(e) {
                            if(newAppointmentModal && e.target === newAppointmentModal) {
                                          newAppointmentModal.classList.add('hidden');
                            }
                            if(viewAppointmentModal && e.target === viewAppointmentModal) {
                                          viewAppointmentModal.classList.add('hidden');
                            }
              });
});
</script>
@endsection