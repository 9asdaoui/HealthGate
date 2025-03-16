@extends('layouts.patient')

@section('title', 'Patient Profile')

@section('page-title', 'My Profile')

@section('breadcrumb', 'Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Profile Summary Card -->
<div class="lg:col-span-1 space-y-6">
<!-- Profile Image & Basic Info Card -->
<div class="bg-white rounded-xl shadow-card overflow-hidden card">
              <div class="bg-gradient-to-r from-accent to-darkTeal p-6 text-center">
                            <div class="relative inline-block">
                                          <img id="profile-image" src="{{ auth()->user()->image }}" alt="Profile" class="h-24 w-24 rounded-full border-4 border-white object-cover mx-auto">
                                          <label for="image-upload" class="absolute bottom-0 right-0 bg-accent hover:bg-accentHover text-white rounded-full p-2 cursor-pointer shadow-lg">
                                                        <i class="fas fa-camera"></i>
                                          </label>
                                          <input type="file" id="image-upload" class="hidden">
                            </div>
                                          <h2 class="text-white text-xl font-semibold mt-4">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
                            <p class="text-white/80 text-sm">Patient ID: #{{ auth()->user()->id }}</p>
              </div>
              
              <div class="p-6 space-y-4">
                            <div class="flex items-center">
                                          <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                                                        <i class="fas fa-envelope"></i>
                                          </div>
                                          <div class="ml-4">
                                                        <p class="text-sm text-gray-500">Email</p>
                                                        <p class="font-medium">{{ auth()->user()->email }}</p>
                                          </div>
                            </div>

                            <div class="flex items-center">
                                          <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                                                        <i class="fas fa-venus-mars"></i>
                                          </div>
                                          <div class="ml-4">
                                                        <p class="text-sm text-gray-500">Gender</p>
                                                        <p class="font-medium capitalize">{{ auth()->user()->gender }}</p>
                                          </div>
                            </div>

                            <div class="flex items-center">
                                          <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                                                        <i class="fas fa-birthday-cake"></i>
                                          </div>
                                          <div class="ml-4">
                                                        <p class="text-sm text-gray-500">Date of Birth</p>
                                                        <p class="font-medium">{{ date('M d, Y', strtotime(auth()->user()->patient->date_of_birth)) }}</p>
                                          </div>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-100">
                                          <button id="edit-profile-btn" class="w-full bg-accent hover:bg-accentHover text-white py-2 px-4 rounded-lg transition-colors font-medium">
                                                        <i class="fas fa-edit mr-2"></i> Edit Profile
                                          </button>
                            </div>
              </div>
</div>

<!-- Health Metrics Card -->
<div class="bg-white rounded-xl shadow-card p-6 card">
              <h3 class="font-semibold text-lg mb-4 flex items-center">
                            <i class="fas fa-heartbeat text-accent mr-2"></i>
                            Health Metrics
              </h3>
              
              <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                          <div class="flex items-center">
                                                        <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                                                      <i class="fas fa-weight"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                                      <p class="text-sm text-gray-500">Weight</p>
                                                                      <p class="font-medium">{{ auth()->user()->patient->weight }} kg</p>   
                                                        </div>
                                          </div>
                                          <button class="text-accent hover:text-accentHover">
                                                        <i class="fas fa-pencil-alt"></i>
                                          </button>
                            </div>

                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                          <div class="flex items-center">
                                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                                                      <i class="fas fa-ruler-vertical"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                                      <p class="text-sm text-gray-500">Height</p>
                                                                      <p class="font-medium">{{ auth()->user()->patient->height }} cm</p>
                                                        </div>
                                          </div>
                                          <button class="text-accent hover:text-accentHover">
                                                        <i class="fas fa-pencil-alt"></i>
                                          </button>
                            </div>

                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                          <div class="flex items-center">
                                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                                                      <i class="fas fa-calculator"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                                      <p class="text-sm text-gray-500">BMI</p>
                                                                      @php
                                                                                    $height_m = auth()->user()->patient->height / 100;
                                                                                    $bmi = auth()->user()->patient->weight / ($height_m * $height_m);
                                                                                    $bmi_status = '';
                                                                                    
                                                                                    if ($bmi < 18.5) {
                                                                                                  $bmi_status = 'Underweight';
                                                                                                  $bmi_color = 'text-blue-500';
                                                                                    } else if ($bmi >= 18.5 && $bmi <= 24.9) {
                                                                                                  $bmi_status = 'Normal';
                                                                                                  $bmi_color = 'text-green-500';
                                                                                    } else if ($bmi >= 25 && $bmi <= 29.9) {
                                                                                                  $bmi_status = 'Overweight';
                                                                                                  $bmi_color = 'text-yellow-500';
                                                                                    } else {
                                                                                                  $bmi_status = 'Obese';
                                                                                                  $bmi_color = 'text-red-500';
                                                                                    }
                                                                      @endphp
                                                                      <p class="font-medium">{{ number_format($bmi, 1) }} <span class="text-sm {{ $bmi_color }}">({{ $bmi_status }})</span></p>
                                                        </div>
                                          </div>
                                          <div class="text-xs text-gray-500">
                                                        <span>Calculated</span>
                                          </div>
                            </div>
              </div>
</div>
</div>

<!-- Main Profile Content -->
<div class="lg:col-span-2 space-y-6">
<!-- Personal Information Card -->
<div class="bg-white rounded-xl shadow-card p-6 card">
              <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold text-lg flex items-center">
                                          <i class="fas fa-user text-accent mr-2"></i>
                                          Personal Information
                            </h3>
                            <button id="edit-personal-info-btn" class="text-accent hover:text-accentHover font-medium text-sm">
                                          <i class="fas fa-edit mr-1"></i> Edit
                            </button>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                          <label class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                                          <div class="p-3 bg-gray-50 rounded-lg">{{ auth()->user()->first_name }}</div>
                            </div>
                            
                            <div>
                                          <label class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                                          <div class="p-3 bg-gray-50 rounded-lg">{{ auth()->user()->last_name }}</div>
                            </div>
                            
                            <div>
                                          <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                          <div class="p-3 bg-gray-50 rounded-lg">{{ auth()->user()->email }}</div>
                            </div>
                            
                            <div>
                                          <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                                          <div class="p-3 bg-gray-50 rounded-lg">{{ date('M d, Y', strtotime(auth()->user()->patient->date_of_birth)) }}</div>
                            </div>
                            
                            <div>
                                          <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                                          <div class="p-3 bg-gray-50 rounded-lg capitalize">{{ auth()->user()->gender }}</div>
                            </div>
                            
                            <div>
                                          <label class="block text-sm font-medium text-gray-500 mb-1">Member Since</label>
                                          <div class="p-3 bg-gray-50 rounded-lg">{{ auth()->user()->created_at->format('M d, Y') }}</div>
                            </div>
              </div>
</div>

<!-- Security Settings Card -->
<div class="bg-white rounded-xl shadow-card p-6 card">
              <h3 class="font-semibold text-lg mb-6 flex items-center">
                            <i class="fas fa-shield-alt text-accent mr-2"></i>
                            Security Settings
              </h3>
              
              <form action="{{route('change-password')}}" method="POST" id="password-change-form" class="space-y-4">
                            @csrf
                            <div>
                                          <label for="current_password" class="block text-sm font-medium text-gray-500 mb-1">Current Password</label>
                                          <input type="password" id="current_password" name="current_password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all" placeholder="Enter your current password">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                          <div>
                                                        <label for="new_password" class="block text-sm font-medium text-gray-500 mb-1">New Password</label>
                                                        <input type="password" id="new_password" name="new_password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all" placeholder="Enter new password">
                                          </div>
                                          
                                          <div>
                                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-500 mb-1">Confirm New Password</label>
                                                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all" placeholder="Confirm new password">
                                          </div>
                            </div>
                            
                            <div class="pt-2">
                                          <button type="submit" class="bg-accent hover:bg-accentHover text-white py-2.5 px-4 rounded-lg transition-colors font-medium">
                                                        Update Password
                                          </button>
                            </div>
              </form>
</div>

<!-- Notification Preferences -->
<div class="bg-white rounded-xl shadow-card p-6 card">
              <h3 class="font-semibold text-lg mb-6 flex items-center">
                            <i class="fas fa-bell text-accent mr-2"></i>
                            Notification Preferences
              </h3>
              
              <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                          <div>
                                                        <h4 class="font-medium">Appointment Reminders</h4>
                                                        <p class="text-sm text-gray-500">Receive notifications about upcoming appointments</p>
                                          </div>
                                          <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent"></div>
                                          </label>
                            </div>
                            
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                          <div>
                                                        <h4 class="font-medium">Medication Reminders</h4>
                                                        <p class="text-sm text-gray-500">Get reminders about your medication schedule</p>
                                          </div>
                                          <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent"></div>
                                          </label>
                            </div>
                            
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                          <div>
                                                        <h4 class="font-medium">Health Tips</h4>
                                                        <p class="text-sm text-gray-500">Receive personalized health tips and advice</p>
                                          </div>
                                          <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer">
                                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent"></div>
                                          </label>
                            </div>
                            
                            <div class="flex items-center justify-between py-3">
                                          <div>
                                                        <h4 class="font-medium">System Updates</h4>
                                                        <p class="text-sm text-gray-500">Get notified about system updates and new features</p>
                                          </div>
                                          <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent"></div>
                                          </label>
                            </div>
              </div>
</div>
</div>
</div>

<!-- Edit Profile Modal (Hidden by default) -->
<div id="edit-profile-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
<div class="p-6">
              <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Edit Profile</h3>
                            <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                                          <i class="fas fa-times"></i>
                            </button>
              </div>
              
              <form action="#" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="text-center mb-4">
                                          <div class="relative inline-block">
                                                        <img id="modal-profile-image" src="{{ auth()->user()->image }}" alt="Profile" class="h-24 w-24 rounded-full border-2 border-accent object-cover mx-auto">
                                                        <label for="modal-image-upload" class="absolute bottom-0 right-0 bg-accent hover:bg-accentHover text-white rounded-full p-2 cursor-pointer shadow-lg">
                                                                      <i class="fas fa-camera"></i>
                                                        </label>
                                                        <input type="file" id="modal-image-upload" name="image" class="hidden">
                                          </div>
                            </div>
                            
                            <div>
                                          <label for="first_name" class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                                          <input type="text" id="first_name" name="first_name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" value="{{ auth()->user()->first_name }}">
                            </div>
                            
                            <div>
                                          <label for="last_name" class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                                          <input type="text" id="last_name" name="last_name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" value="{{ auth()->user()->last_name }}">
                            </div>
                            
                            <div>
                                          <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                          <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" value="{{ auth()->user()->email }}">
                            </div>
                            
                            <div>
                                          <label for="date_of_birth" class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                                          <input type="date" id="date_of_birth" name="date_of_birth" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent" value="{{ auth()->user()->patient->date_of_birth }}">
                            </div>
                            
                            <div>
                                          <label for="gender" class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                                          <select id="gender" name="gender" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent">
                                                        <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                                          </select>
                            </div>
                            
                            <div class="pt-2">
                                          <button type="submit" class="w-full bg-accent hover:bg-accentHover text-white py-2.5 px-4 rounded-lg transition-colors font-medium">
                                                        Save Changes
                                          </button>
                            </div>
              </form>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
// Profile image upload preview
const imageUpload = document.getElementById('image-upload');
const profileImage = document.getElementById('profile-image');
const modalImageUpload = document.getElementById('modal-image-upload');
const modalProfileImage = document.getElementById('modal-profile-image');

if(imageUpload && profileImage) {
imageUpload.addEventListener('change', function(e) {
              if(e.target.files.length > 0) {
                            const src = URL.createObjectURL(e.target.files[0]);
                            profileImage.src = src;
                            if(modalProfileImage) modalProfileImage.src = src;
              }
});
}

if(modalImageUpload && modalProfileImage) {
modalImageUpload.addEventListener('change', function(e) {
              if(e.target.files.length > 0) {
                            const src = URL.createObjectURL(e.target.files[0]);
                            modalProfileImage.src = src;
                            if(profileImage) profileImage.src = src;
              }
});
}

// Modal controls
const editProfileBtn = document.getElementById('edit-profile-btn');
const editProfileModal = document.getElementById('edit-profile-modal');
const closeModalBtn = document.getElementById('close-modal');

if(editProfileBtn && editProfileModal) {
editProfileBtn.addEventListener('click', function() {
              editProfileModal.classList.remove('hidden');
});
}

if(closeModalBtn && editProfileModal) {
closeModalBtn.addEventListener('click', function() {
              editProfileModal.classList.add('hidden');
});
}

// Close modal when clicking outside
window.addEventListener('click', function(e) {
if(editProfileModal && e.target === editProfileModal) {
              editProfileModal.classList.add('hidden');
}
});

// Edit personal information
const editPersonalInfoBtn = document.getElementById('edit-personal-info-btn');
if(editPersonalInfoBtn && editProfileModal) {
editPersonalInfoBtn.addEventListener('click', function() {
              editProfileModal.classList.remove('hidden');
});
}
});
</script>
@endsection