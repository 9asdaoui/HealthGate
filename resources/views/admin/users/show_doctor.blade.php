@extends('layouts.admin')

@section('title', 'Doctor Details')

@section('page-title', 'User Management')

@section('breadcrumb')
    <a href="{{ route('admin.users') }}" class="hover:text-accent">Users</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>Doctor</span>
@endsection

@section('styles')
<style>
    .doctor-profile-header {
        position: relative;
        background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
        border-radius: 12px;
        overflow: hidden;
        border-left: 4px solid theme('colors.accent');
    }
    
    .profile-avatar {
        border: 4px solid theme('colors.accent');
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
    }
    
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
    }
    
    .modal-container {
        z-index: 50;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-80 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
    </div>

    <!-- Doctor Profile Header -->
    <div class="doctor-profile-header p-6 mb-6 shadow-lg">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
            <div class="w-32 h-32 rounded-full overflow-hidden profile-avatar bg-primary flex-shrink-0">
                @if($doctor->user->image)
                    <img src="{{ $doctor->user->image }}" alt="{{ $doctor->user->first_name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-accent text-white text-4xl font-bold">
                        {{ substr($doctor->user->first_name, 0, 1) }}{{ substr($doctor->user->last_name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="flex-1">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold">Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</h1>
                        <p class="text-lightText text-lg">{{ $doctor->speciality }} Specialist</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 flex space-x-2">
                        <button onclick="openEditProfileModal()" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </button>
                        <button onclick="openDeleteConfirmModal()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                            <i class="fas fa-trash-alt mr-2"></i>Delete
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-primary rounded-lg p-3 flex items-center space-x-3">
                        <i class="fas fa-envelope text-accent"></i>
                        <span>{{ $doctor->user->email }}</span>
                    </div>
                    <div class="bg-primary rounded-lg p-3 flex items-center space-x-3">
                        <i class="fas fa-user-md text-accent"></i>
                        <span>{{ $doctor->experience }} Years Experience</span>
                    </div>
                    <div class="bg-primary rounded-lg p-3 flex items-center space-x-3">
                        <i class="fas fa-venus-mars text-accent"></i>
                        <span>{{ ucfirst($doctor->user->gender) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Doctor Stats and Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="stat-card bg-secondary p-6 rounded-lg shadow-md border border-borderColor">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Patients</h3>
                <i class="fas fa-users text-2xl text-accent"></i>
            </div>
            <p class="text-3xl font-bold">{{ $doctor->getPatients()->count() }}</p>
            <p class="text-sm text-lightText mt-2">Total patients under care</p>
        </div>
        
        <div class="stat-card bg-secondary p-6 rounded-lg shadow-md border border-borderColor">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Appointments</h3>
                <i class="fas fa-calendar-check text-2xl text-accent"></i>
            </div>
            <p class="text-3xl font-bold">{{ $doctor->appointments()->count() }}</p>
            <p class="text-sm text-lightText mt-2">Total appointments</p>
        </div>
        
        <div class="stat-card bg-secondary p-6 rounded-lg shadow-md border border-borderColor">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Medical Records</h3>
                <i class="fas fa-clipboard-list text-2xl text-accent"></i>
            </div>
            <p class="text-3xl font-bold">{{ $doctor->medicals()->count() }}</p>
            <p class="text-sm text-lightText mt-2">Total medical records created</p>
        </div>
    </div>
    
    <!-- Recent Patients -->
    <div class="bg-secondary rounded-lg shadow-md border border-borderColor overflow-hidden mb-6">
        <div class="p-4 border-b border-borderColor flex justify-between items-center">
            <h2 class="text-xl font-bold">Recent Patients</h2>
            <button onclick="openDepartmentModal()" class="px-3 py-1 bg-accent text-white rounded hover:bg-opacity-80 transition duration-200 text-sm">
                <i class="fas fa-hospital mr-1"></i>Assign Department
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-borderColor">
                <thead class="bg-primary">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-secondary divide-y divide-borderColor">
                    @forelse($doctor->appointments()->latest()->take(5)->get() as $appointment)
                        <tr class="hover:bg-primary transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-accent font-bold overflow-hidden">
                                        @if($appointment->patient->user->image)
                                            <img src="{{ $appointment->patient->user->image }}" alt="{{ $appointment->patient->user->first_name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ substr($appointment->patient->user->first_name, 0, 1) }}{{ substr($appointment->patient->user->last_name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium">{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</div>
                                        <div class="text-sm text-lightText">{{ $appointment->patient->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at {{ $appointment->appointment_time }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($appointment->status === 'completed')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-500 bg-opacity-20 text-green-500">Completed</span>
                                @elseif($appointment->status === 'scheduled')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-500 bg-opacity-20 text-blue-500">Scheduled</span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-500 bg-opacity-20 text-red-500">Cancelled</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-500 bg-opacity-20 text-yellow-500">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-lightText">No appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal-overlay fixed inset-0 hidden">
    <div class="modal-container fixed inset-0 flex items-center justify-center">
        <div class="bg-secondary rounded-lg shadow-xl max-w-2xl w-full mx-4 overflow-hidden">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center">
                <h3 class="text-xl font-bold">Edit Doctor Profile</h3>
                <button onclick="closeEditProfileModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium mb-1">First Name</label>
                        <input 
                            type="text" 
                            name="first_name" 
                            id="first_name" 
                            value="{{ $doctor->user->first_name }}"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                            required
                        >
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium mb-1">Last Name</label>
                        <input 
                            type="text" 
                            name="last_name" 
                            id="last_name" 
                            value="{{ $doctor->user->last_name }}"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                            required
                        >
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-1">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ $doctor->user->email }}"
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                        required
                    >
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="speciality" class="block text-sm font-medium mb-1">Speciality</label>
                        <input 
                            type="text" 
                            name="speciality" 
                            id="speciality" 
                            value="{{ $doctor->speciality }}"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                            required
                        >
                    </div>
                    <div>
                        <label for="experience" class="block text-sm font-medium mb-1">Experience (years)</label>
                        <input 
                            type="number" 
                            name="experience" 
                            id="experience" 
                            value="{{ $doctor->experience }}"
                            min="0"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                            required
                        >
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="gender" class="block text-sm font-medium mb-1">Gender</label>
                    <select 
                        name="gender" 
                        id="gender" 
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                        required
                    >
                        <option value="male" {{ $doctor->user->gender === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $doctor->user->gender === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ $doctor->user->gender === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium mb-1">Profile Image</label>
                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                    >
                    <p class="text-xs text-lightText mt-1">Leave empty to keep current image</p>
                </div>
                
                <div class="text-right">
                    <button type="button" onclick="closeEditProfileModal()" class="px-4 py-2 border border-borderColor rounded-lg mr-2 hover:bg-primary transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Department Modal -->
<div id="departmentModal" class="modal-overlay fixed inset-0 hidden">
    <div class="modal-container fixed inset-0 flex items-center justify-center">
        <div class="bg-secondary rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center">
                <h3 class="text-xl font-bold">Assign Department</h3>
                <button onclick="closeDepartmentModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.doctors.update-department', $doctor->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="department_id" class="block text-sm font-medium mb-1">Department</label>
                    <select 
                        name="department_id" 
                        id="department_id" 
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"
                        required
                    >
                        <option value="">Select a department</option>
                        @foreach(\App\Models\Department::all() as $department)
                            <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="text-right">
                    <button type="button" onclick="closeDepartmentModal()" class="px-4 py-2 border border-borderColor rounded-lg mr-2 hover:bg-primary transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                        Assign Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal-overlay fixed inset-0 hidden">
    <div class="modal-container fixed inset-0 flex items-center justify-center">
        <div class="bg-secondary rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center">
                <h3 class="text-xl font-bold">Confirm Delete</h3>
                <button onclick="closeDeleteConfirmModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4 text-red-500">
                    <i class="fas fa-exclamation-triangle text-4xl mr-4"></i>
                    <p>Are you sure you want to delete Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}? This action cannot be undone.</p>
                </div>
                
                <p class="mb-4 text-sm text-lightText">This will remove the doctor account and all associated data including appointments, medical records, and patient relationships.</p>
                
                <div class="text-right">
                    <button type="button" onclick="closeDeleteConfirmModal()" class="px-4 py-2 border border-borderColor rounded-lg mr-2 hover:bg-primary transition duration-200">
                        Cancel
                    </button>
                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                            Delete Doctor
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openEditProfileModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    
    function closeEditProfileModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
    
    function openDepartmentModal() {
        document.getElementById('departmentModal').classList.remove('hidden');
    }
    
    function closeDepartmentModal() {
        document.getElementById('departmentModal').classList.add('hidden');
    }
    
    function openDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
    
    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    }
    
    // Close modals when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
</script>
@endsection