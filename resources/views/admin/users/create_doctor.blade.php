@extends('layouts.admin')

@section('title', 'Create Doctor')

@section('page-title', 'Create New Doctor')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-accent">Dashboard</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <a href="{{ route('admin.users') }}" class="hover:text-accent">Users</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>Create Doctor</span>
@endsection

@section('styles')
<style>
    .form-card {
        transition: all 0.3s ease;
        border-left: 4px solid theme('colors.accent');
    }
    
    .input-field {
        background-color: #2a2a2a;
        border: 1px solid theme('colors.borderColor');
        color: #ffffff;
        transition: all 0.3s ease;
    }
    
    .input-field:focus {
        border-color: theme('colors.accent');
        box-shadow: 0 0 0 2px rgba(0, 169, 157, 0.2);
    }
    
    .form-section {
        background: linear-gradient(135deg, #252525 0%, #1E1E1E 100%);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .radio-label {
        color: #ffffff;
    }

    label {
        color: #e0e0e0;
    }

    select option {
        background-color: #2a2a2a;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <div class="bg-secondary rounded-lg shadow-md overflow-hidden border border-borderColor mb-6">
        <div class="p-4 border-b border-borderColor flex justify-between items-center">
            <h2 class="text-xl font-bold">Create New Doctor</h2>
        </div>
        
        <form action="{{ route('admin.users.store.doctor') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <!-- Personal Information -->
            <div class="form-section p-5 mb-6">
                <h3 class="text-lg font-semibold mb-4 text-accent">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" 
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password"
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Gender</label>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center radio-label">
                                <input type="radio" name="gender" value="male" class="text-accent" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center radio-label">
                                <input type="radio" name="gender" value="female" class="text-accent" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <span class="ml-2">Female</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Profile Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium mb-2">Profile Image</label>
                        <input type="file" id="image" name="image" 
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none">
                        <p class="text-xs text-lightText mt-1">Upload a profile picture (optional)</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Professional Information -->
            <div class="form-section p-5 mb-6">
                <h3 class="text-lg font-semibold mb-4 text-accent">Professional Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-medium mb-2">Department</label>
                        <select id="department_id" name="department_id" class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Speciality -->
                    <div>
                        <label for="speciality" class="block text-sm font-medium mb-2">Speciality</label>
                        <input type="text" id="speciality" name="speciality" value="{{ old('speciality') }}"
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                        @error('speciality')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Experience (Years) -->
                    <div>
                        <label for="experience" class="block text-sm font-medium mb-2">Experience (Years)</label>
                        <input type="number" id="experience" name="experience" min="0" value="{{ old('experience') }}"
                               class="input-field w-full px-4 py-2 rounded-lg focus:outline-none" required>
                        @error('experience')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Account Settings -->
            <div class="form-section p-5 mb-6">
                <h3 class="text-lg font-semibold mb-4 text-accent">Account Settings</h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div class="flex items-center">
                        <input type="hidden" name="send_credentials" value="0">
                        <input type="checkbox" id="send_credentials" name="send_credentials" value="1" class="text-accent" {{ old('send_credentials') ? 'checked' : '' }}>
                        <label for="send_credentials" class="ml-2 text-sm">Send login credentials to doctor's email</label>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.users') }}" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                    Create Doctor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview uploaded image
    const imageInput = document.getElementById('image');
    imageInput?.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // You could add image preview here if needed
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection