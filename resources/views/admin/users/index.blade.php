@extends('layouts.admin')

@section('title', 'User Management')

@section('styles')
<style>
    .user-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-left-color: theme('colors.accent');
    }
    .badge-admin {
        background-color: #FF6B6B;
    }
    .badge-doctor {
        background-color: #4ECDC4;
    }
    .badge-patient {
        background-color: #6A0572;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">User Management</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.create.doctor') }}" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                <i class="fas fa-user-md mr-2"></i>Add Doctor
            </a>

        </div>
    </div>

    <!-- Filters -->
    <div class="bg-secondary rounded-lg p-4 mb-6 border border-borderColor">
        <form action="{{ route('admin.users') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium mb-1">Search</label>
                <input 
                    type="text" 
                    name="search" 
                    id="search" 
                    placeholder="Search by name..." 
                    value="{{ request('search') }}"
                    class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                >
            </div>
            
            <div class="w-full md:w-1/4">
                <label for="role" class="block text-sm font-medium mb-1">Filter by Role</label>
                <select 
                    name="role" 
                    id="role" 
                    class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                    onchange="toggleSpecialityFilter()"
                >
                    <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Doctor</option>
                    <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>Patient</option>
                </select>
            </div>
            
            <div id="specialityFilter" class="w-full md:w-1/4 {{ request('role') == '2' ? '' : 'hidden' }}">
                <label for="speciality" class="block text-sm font-medium mb-1">Filter by Speciality</label>
                <select 
                    name="speciality" 
                    id="speciality" 
                    class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                >
                    <option value="all">All Specialities</option>
                    <option value="Cardiology" {{ request('speciality') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                    <option value="Neurology" {{ request('speciality') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                    <option value="Dermatology" {{ request('speciality') == 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                    <option value="Pediatrics" {{ request('speciality') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                    <option value="Orthopedics" {{ request('speciality') == 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                    <option value="Gynecology" {{ request('speciality') == 'Gynecology' ? 'selected' : '' }}>Gynecology</option>
                    <option value="Ophthalmology" {{ request('speciality') == 'Ophthalmology' ? 'selected' : '' }}>Ophthalmology</option>
                </select>
            </div>
            
            <div class="self-end">
                <button type="submit" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Users List -->
    <div class="bg-secondary rounded-lg border border-borderColor overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-borderColor">
                <thead class="bg-primary">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-secondary divide-y divide-borderColor">
                    @forelse($queryUsers as $userA)
                    <tr class="user-card hover:bg-primary">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 mr-3">
                                    @if($userA->image)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $userA->image) }}" alt="{{ $userA->first_name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-accent flex items-center justify-center text-white">
                                            {{ substr($userA->first_name, 0, 1) }}{{ substr($userA->last_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium">{{ $userA->first_name }} {{ $userA->last_name }}</div>
                                    <div class="text-sm text-lightText">{{ $userA->gender ?? 'Not specified' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">{{ $userA->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($userA->role)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $userA->role->name == 'Admin' ? 'badge-admin' : ($userA->role->name == 'Doctor' ? 'badge-doctor' : 'badge-patient') }}
                                    text-white">
                                    {{ $userA->role->name }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-500 text-white">
                                    Unknown
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($userA->role && $userA->role->id == 2 && $userA->doctor)
                                <div>Speciality: {{ $userA->doctor->speciality ?? 'Not specified' }}</div>
                                <div>Experience: {{ $userA->doctor->experience ?? 'Not specified' }} years</div>
                            @elseif($userA->role && $userA->role->id == 3 && $userA->patient)
                                <div>DOB: {{ $userA->patient->date_of_birth ? $userA->patient->date_of_birth->format('M d, Y') : 'Not specified' }}</div>
                                <div>Height: {{ $userA->patient->height ?? 'Not specified' }} cm</div>
                                <div>Weight: {{ $userA->patient->weight ?? 'Not specified' }} kg</div>
                            @else
                                <div class="text-lightText">No additional details</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                @if($userA->role && $userA->role->id == 3)
                                    <a onclick="showPatient({{ $userA->id }})"
                                       class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition duration-200 text-xs flex items-center">
                                        <i class="fas fa-user mr-1"></i> View Profile
                                    </a>
                                @endif
                                @if($userA->role && $userA->role->id == 2)
                                    <a href="{{ route('admin.users.showDoctor', $userA->id) }}"
                                       class="px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition duration-200 text-xs flex items-center">
                                        <i class="fas fa-user-md mr-1"></i> View Doctor
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-lightText">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-borderColor">
            {{ $queryUsers->links() }}
        </div>
    </div>


</div>
@endsection

@section('scripts')
<script>
    function toggleSpecialityFilter() {
        const roleSelect = document.getElementById('role');
        const specialityFilter = document.getElementById('specialityFilter');
        
        if (roleSelect.value === '2') {
            specialityFilter.classList.remove('hidden');
        } else {
            specialityFilter.classList.add('hidden');
            document.getElementById('speciality').value = 'all';
        }
    }
    function showPatient(id){
        fetch(`/api/patient/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {

            showPatientModal(data);
        })
        .catch(error => {
            console.error('Error fetching patient data:', error);
            alert('Failed to load patient data. Please try again.');
        });
    }

    function showPatientModal(data){
        const modalBackdrop = document.createElement('div');
        modalBackdrop.classList.add('fixed', 'inset-0', 'bg-black', 'bg-opacity-50', 'z-40', 'flex', 'items-center', 'justify-center');
        document.body.appendChild(modalBackdrop);


        const dob = new Date(data.date_of_birth);
        const formattedDob = dob.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        const modalContent = `
            <div class="bg-secondary rounded-lg shadow-xl overflow-hidden max-w-2xl w-full z-50 relative">
                <!-- Header -->
                <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center">
                    <h3 class="text-xl font-bold">Patient Profile</h3>
                    <button id="closePatientModal" class="text-lightText hover:text-accent">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Patient Image -->
                        <div class="w-full md:w-1/3 flex flex-col items-center">
                            <img src="${data.image}" alt="${data.first_name} ${data.last_name}" 
                                 class="w-48 h-48 object-cover rounded-full border-4 border-accent">
                            <h4 class="mt-4 text-xl font-bold text-center">${data.first_name} ${data.last_name}</h4>
                            <p class="text-accent">#${data.id}</p>
                        </div>
                        
                        <!-- Patient Details -->
                        <div class="w-full md:w-2/3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-borderColor rounded-lg p-3">
                                    <p class="text-sm text-lightText">Email</p>
                                    <p class="font-medium">${data.email}</p>
                                </div>
                                <div class="border border-borderColor rounded-lg p-3">
                                    <p class="text-sm text-lightText">Gender</p>
                                    <p class="font-medium capitalize">${data.gender}</p>
                                </div>
                                <div class="border border-borderColor rounded-lg p-3">
                                    <p class="text-sm text-lightText">Date of Birth</p>
                                    <p class="font-medium">${formattedDob} (${age} years)</p>
                                </div>
                                <div class="border border-borderColor rounded-lg p-3">
                                    <p class="text-sm text-lightText">Height</p>
                                    <p class="font-medium">${data.height} cm</p>
                                </div>
                                <div class="border border-borderColor rounded-lg p-3">
                                    <p class="text-sm text-lightText">Weight</p>
                                    <p class="font-medium">${data.weight} kg</p>
                                </div>
                                <div class="border border-borderColor rounded-lg p-3">
                                    <p class="text-sm text-lightText">BMI</p>
                                    <p class="font-medium">${(data.weight / ((data.height / 100) * (data.height / 100))).toFixed(2)} kg/m²</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="bg-primary p-4 border-t border-borderColor flex justify-end">
                    <button id="closePatientModalBtn" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                        Close
                    </button>
                </div>
            </div>
        `;

        modalBackdrop.innerHTML = modalContent;

        const closeButtons = [
            modalBackdrop.querySelector('#closePatientModal'),
            modalBackdrop.querySelector('#closePatientModalBtn')
        ];

        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.body.removeChild(modalBackdrop);
            });
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        toggleSpecialityFilter();
    });
</script>
@endsection