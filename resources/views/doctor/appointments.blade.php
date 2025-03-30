@extends('layouts.doctor')

@section('title', 'Manage Appointments')

@section('page-title', 'Manage Appointments')

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
</style>
@endsection

@section('content')
<div class="py-6 px-4 md:px-8">
              <div class="bg-white rounded-xl shadow-md p-6">
                            <!-- Header with filters -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                                          <h2 class="text-lg font-bold text-gray-800 mb-4 md:mb-0">Appointments Management</h2>
                                          
                                          <div class="flex flex-col sm:flex-row gap-4">
                                                        <!-- Search -->
                                                        <div class="relative">
                                                                      <input type="text" id="search" 
                                                                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent"
                                                                                    placeholder="Search by patient name...">
                                                                      <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                                        </div>

                                                        <!-- Filter -->
                                                        <div class="relative">
                                                                      <select id="status-filter" class="pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent appearance-none bg-white">
                                                                                    <option value="all">All Appointments</option>
                                                                                    <option value="pending">Pending</option>
                                                                                    <option value="upcoming">Upcoming</option>
                                                                                    <option value="completed">Completed</option>
                                                                                    <option value="cancelled">Cancelled</option>
                                                                      </select>
                                                                      <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                                        </div>
                                                        
                                                        <!-- Date filter -->
                                                        <input type="date" class="pl-4 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                                          </div>
                            </div>
                            
                            <!-- Appointment categories -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                          <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                                        <div class="flex items-center justify-between">
                                                                      <div>
                                                                                    <p class="text-sm text-blue-600">Today's Appointments</p>
                                                                                    <p class="text-2xl font-bold text-blue-800">
                                                                                                  {{ $appointments->where('appointment_date', date('Y-m-d'))->count() }}
                                                                                    </p>
                                                                      </div>
                                                                      <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                                                    <i class="fas fa-calendar-day text-blue-600"></i>
                                                                      </div>
                                                        </div>
                                          </div>
                                          
                                          <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                                        <div class="flex items-center justify-between">
                                                                      <div>
                                                                                    <p class="text-sm text-yellow-600">Pending</p>
                                                                                    <p class="text-2xl font-bold text-yellow-800">
                                                                                                  {{ $appointments->where('status', 'pending')->count() }}
                                                                                    </p>
                                                                      </div>
                                                                      <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                                                                    <i class="fas fa-clock text-yellow-600"></i>
                                                                      </div>
                                                        </div>
                                          </div>
                                          
                                          <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                                        <div class="flex items-center justify-between">
                                                                      <div>
                                                                                    <p class="text-sm text-green-600">Completed</p>
                                                                                    <p class="text-2xl font-bold text-green-800">
                                                                                                  {{ $appointments->where('status', 'completed')->count() }}
                                                                                    </p>
                                                                      </div>
                                                                      <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                                                    <i class="fas fa-check-circle text-green-600"></i>
                                                                      </div>
                                                        </div>
                                          </div>
                                          
                                          <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                                                        <div class="flex items-center justify-between">
                                                                      <div>
                                                                                    <p class="text-sm text-purple-600">Upcoming</p>
                                                                                    <p class="text-2xl font-bold text-purple-800">
                                                                                                  {{ $appointments->where('status', 'upcoming')->count() }}
                                                                                    </p>
                                                                      </div>
                                                                      <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                                                    <i class="fas fa-calendar-alt text-purple-600"></i>
                                                                      </div>
                                                        </div>
                                          </div>
                            </div>

                            <!-- Appointments Table -->
                            <div class="overflow-x-auto">
                                          <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                                      <tr>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                                                  Patient
                                                                                    </th>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                                                  Date & Time
                                                                                    </th>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                                                  Status
                                                                                    </th>
                                                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                                                  Actions
                                                                                    </th>
                                                                      </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                                      @forelse($appointments as $appointment)
                                                                      <tr class="hover:bg-gray-50">
                                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                                                  <div class="flex items-center">
                                                                                                                <div class="h-10 w-10 flex-shrink-0">
                                                                                                                              @if($appointment->patient->user->image)
                                                                                                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $appointment->patient->user->image }}" alt="">
                                                                                                                              @else
                                                                                                                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                                                                                                                          <span class="text-blue-600 font-medium text-sm">
                                                                                                                                                                        {{ substr($appointment->patient->user->first_name, 0, 1) }}{{ substr($appointment->patient->user->last_name, 0, 1) }}
                                                                                                                                                          </span>
                                                                                                                                            </div>
                                                                                                                              @endif
                                                                                                                </div>
                                                                                                                <div class="ml-4">
                                                                                                                              <div class="text-sm font-medium text-gray-900">
                                                                                                                                            {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}
                                                                                                                              </div>
                                                                                                                              <div class="text-xs text-gray-500">
                                                                                                                                            ID: {{ $appointment->patient->id }}
                                                                                                                              </div>
                                                                                                                </div>
                                                                                                  </div>
                                                                                    </td>
                                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                                                  <div class="text-sm text-gray-900">
                                                                                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                                                                                  </div>
                                                                                                  <div class="text-xs text-gray-500">
                                                                                                                {{ $appointment->appointment_time }}
                                                                                                  </div>
                                                                                    </td>
                                                                               
                                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                                                  <span class="status-badge status-{{ $appointment->status }}">
                                                                                                                {{ ucfirst($appointment->status) }}
                                                                                                  </span>
                                                                                    </td>
                                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                                                  <div class="flex space-x-2 justify-end">
                                                                                                     
                                                                                                      @if($appointment->status == 'pending')
                                                                                                         <form action="{{ route('doctor.appointments.confirm', $appointment) }}" method="POST" class="inline-block">
                                                                                                            @csrf
                                                                                                            <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-700 rounded-md px-2 py-1 transition-colors" 
                                                                                                                  title="Confirm Appointment">
                                                                                                               <i class="fas fa-calendar-check mr-1"></i> confirm
                                                                                                            </button>
                                                                                                         </form>

                                                                                                         <form action="{{ route('doctor.appointments.reject', $appointment) }}" method="POST" class="inline-block">
                                                                                                            @csrf
                                                                                                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 rounded-md px-2 py-1 transition-colors"
                                                                                                                  title="Reject Appointment" onclick="return confirm('Are you sure you want to reject this appointment?')">
                                                                                                               <i class="fas fa-calendar-times mr-1"></i> reject
                                                                                                            </button>
                                                                                                         </form>
                                                                                                      @endif

                                                                                                      @if($appointment->status == 'upcoming')
                                                                                                         <form action="{{ route('doctor.appointments.complete', $appointment) }}" method="POST" class="inline-block">
                                                                                                            @csrf
                                                                                                            <button type="submit" class="bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-md px-2 py-1 transition-colors"
                                                                                                                  title="Mark as Completed">
                                                                                                               <i class="fas fa-clipboard-check mr-1"></i> Complete
                                                                                                            </button>
                                                                                                         </form>
                                                                                                      @endif
                                                                                                      
                                                                                                      <a href="{{ route('doctor.appointments.view', $appointment) }}" 
                                                                                                         class="text-blue-600 hover:text-blue-900 p-1">
                                                                                                         <i class="fas fa-eye"></i> view
                                                                                                      </a>
                                                                                                </div>
                                                                                    </td>
                                                                      </tr>
                                                                      @empty
                                                                      <tr>
                                                                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                                                                  No appointments found
                                                                                    </td>
                                                                      </tr>
                                                                      @endforelse
                                                        </tbody>
                                          </table>
                            </div>
              </div>
</div>

<script>
       
</script>
@endsection