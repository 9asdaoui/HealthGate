@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('page-title', 'My Profile')

@section('breadcrumb', 'Profile')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Summary Card -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Image & Basic Info Card -->
            <div class="bg-cardBg rounded-xl shadow-md overflow-hidden border border-borderColor">
                <div class="bg-gradient-to-r from-accent to-accentHover p-6 text-center">
                    <div class="relative inline-block">
                        <img id="profile-image" src="{{ $user->image ?? asset('images/default-avatar.png') }}" alt="Profile"
                            class="h-24 w-24 rounded-full border-4 border-white object-cover mx-auto">
                    </div>
                    <h2 class="text-white text-xl font-semibold mt-4">{{ $user->first_name }} {{ $user->last_name }}</h2>
                    <p class="text-white/80 text-sm">Admin ID: #{{ $user->id }}</p>
                </div>

                <div class="p-6 space-y-4 text-darkText">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-secondary flex items-center justify-center text-accent">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-lightText">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-secondary flex items-center justify-center text-accent">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-lightText">Gender</p>
                            <p class="font-medium capitalize">{{ $user->gender }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-secondary flex items-center justify-center text-accent">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-lightText">Role</p>
                            <p class="font-medium capitalize">{{ $user->role->name }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-borderColor">
                        <button id="edit-profile-btn"
                            class="w-full bg-accent hover:bg-accentHover text-white py-2 px-4 rounded-lg transition-colors font-medium">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Profile Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information Card -->
            <div class="bg-cardBg rounded-xl shadow-md p-6 border border-borderColor">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-semibold text-lg flex items-center text-darkText">
                        <i class="fas fa-user text-accent mr-2"></i>
                        Personal Information
                    </h3>
                    <button id="edit-personal-info-btn" class="text-accent hover:text-accentHover font-medium text-sm">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-lightText mb-1">First Name</label>
                        <div class="p-3 bg-secondary rounded-lg text-darkText">{{ $user->first_name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-lightText mb-1">Last Name</label>
                        <div class="p-3 bg-secondary rounded-lg text-darkText">{{ $user->last_name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-lightText mb-1">Email Address</label>
                        <div class="p-3 bg-secondary rounded-lg text-darkText">{{ $user->email }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-lightText mb-1">Role</label>
                        <div class="p-3 bg-secondary rounded-lg text-darkText capitalize">{{ $user->role->name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-lightText mb-1">Gender</label>
                        <div class="p-3 bg-secondary rounded-lg text-darkText capitalize">{{ $user->gender }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-lightText mb-1">Member Since</label>
                        <div class="p-3 bg-secondary rounded-lg text-darkText">{{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Security Settings Card -->
            <div class="bg-cardBg rounded-xl shadow-md p-6 border border-borderColor">
                <h3 class="font-semibold text-lg mb-6 flex items-center text-darkText">
                    <i class="fas fa-shield-alt text-accent mr-2"></i>
                    Security Settings
                </h3>

                <form action="{{ route('change-password') }}" method="POST" id="password-change-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-lightText mb-1">Current
                            Password</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all"
                            placeholder="Enter your current password">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-lightText mb-1">New
                                Password</label>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all"
                                placeholder="Enter new password">
                        </div>

                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-lightText mb-1">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="bg-accent hover:bg-accentHover text-white py-2.5 px-4 rounded-lg transition-colors font-medium">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal (Hidden by default) -->
    <div id="edit-profile-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center p-4">
        <div class="bg-cardBg rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto border border-borderColor">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-darkText">Edit Profile</h3>
                    <button id="close-modal" class="text-lightText hover:text-darkText">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.updateProfile') }}" method="POST" class="space-y-4"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-center mb-4">
                        <div class="relative inline-block">
                            <img id="modal-profile-image" src="{{ $user->image ?? asset('images/default-avatar.png') }}" alt="Profile"
                                class="h-24 w-24 rounded-full border-2 border-accent object-cover mx-auto">
                            <label for="modal-image-upload"
                                class="absolute bottom-0 right-0 bg-accent hover:bg-accentHover text-white rounded-full p-2 cursor-pointer shadow-lg">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="modal-image-upload" name="image" class="hidden"
                                onchange="previewImage(this)">
                        </div>
                    </div>

                    <div>
                        <label for="first_name" class="block text-sm font-medium text-lightText mb-1">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                            class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->first_name }}">
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-lightText mb-1">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                            class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->last_name }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-lightText mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->email }}">
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-lightText mb-1">Gender</label>
                        <select id="gender" name="gender"
                            class="w-full p-3 border border-borderColor bg-secondary text-darkText rounded-lg focus:ring focus:ring-accent/20 focus:border-accent">
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="bg-accent hover:bg-accentHover text-white py-2.5 px-4 rounded-lg transition-colors font-medium w-full">
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
            // Modal controls
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const editProfileModal = document.getElementById('edit-profile-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const editPersonalInfoBtn = document.getElementById('edit-personal-info-btn');

            // Open modal
            if (editProfileBtn && editProfileModal) {
                editProfileBtn.addEventListener('click', function() {
                    editProfileModal.classList.remove('hidden');
                });
            }

            // Edit personal info button also opens modal
            if (editPersonalInfoBtn && editProfileModal) {
                editPersonalInfoBtn.addEventListener('click', function() {
                    editProfileModal.classList.remove('hidden');
                });
            }

            // Close modal
            if (closeModalBtn && editProfileModal) {
                closeModalBtn.addEventListener('click', function() {
                    editProfileModal.classList.add('hidden');
                });
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (editProfileModal && e.target === editProfileModal) {
                    editProfileModal.classList.add('hidden');
                }
            });
        });

        // Image preview function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('modal-profile-image').src = e.target.result;
                    document.getElementById('profile-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection