@extends('layouts.doctor')

@section('title', 'Doctor Profile')

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
                        <img id="profile-image" src="{{ $user->image ?? asset('images/default-avatar.png') }}" alt="Profile"
                            class="h-24 w-24 rounded-full border-4 border-white object-cover mx-auto">

                        <input type="file" id="image-upload" class="hidden">
                    </div>
                    <h2 class="text-white text-xl font-semibold mt-4">Dr. {{ $user->first_name }} {{ $user->last_name }}
                    </h2>
                    <p class="text-white/80 text-sm">Doctor ID: #{{ $user->id }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Speciality</p>
                            <p class="font-medium">{{ $user->doctor->speciality }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Gender</p>
                            <p class="font-medium capitalize">{{ $user->gender }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-accent">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Experience</p>
                            <p class="font-medium">{{ $user->doctor->experience }} Years</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
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
            <!-- Professional Information Card -->
            <div class="bg-white rounded-xl shadow-card p-6 card">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-semibold text-lg flex items-center">
                        <i class="fas fa-user-md text-accent mr-2"></i>
                        Professional Information
                    </h3>
                    <button id="edit-professional-info-btn" class="text-accent hover:text-accentHover font-medium text-sm">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                        <div class="p-3 bg-gray-50 rounded-lg">{{ $user->first_name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                        <div class="p-3 bg-gray-50 rounded-lg">{{ $user->last_name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <div class="p-3 bg-gray-50 rounded-lg">{{ $user->email }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Speciality</label>
                        <div class="p-3 bg-gray-50 rounded-lg">{{ $user->doctor->speciality }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Experience</label>
                        <div class="p-3 bg-gray-50 rounded-lg">{{ $user->doctor->experience }} Years</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <div class="p-3 bg-gray-50 rounded-lg capitalize">{{ $user->gender }}</div>
                    </div>

                    @if ($user->doctor->department)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                            <div class="p-3 bg-gray-50 rounded-lg">{{ $user->doctor->department->name }}</div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Member Since</label>
                        <div class="p-3 bg-gray-50 rounded-lg">{{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Security Settings Card -->
            <div class="bg-white rounded-xl shadow-card p-6 card">
                <h3 class="font-semibold text-lg mb-6 flex items-center">
                    <i class="fas fa-shield-alt text-accent mr-2"></i>
                    Security Settings
                </h3>

                <form action="{{ route('change-password') }}" method="POST" id="password-change-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-500 mb-1">Current
                            Password</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all"
                            placeholder="Enter your current password">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-500 mb-1">New
                                Password</label>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all"
                                placeholder="Enter new password">
                        </div>

                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-500 mb-1">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent transition-all"
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
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Edit Profile</h3>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('doctor.updateProfile') }}" method="POST" class="space-y-4"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-center mb-4">
                        <div class="relative inline-block">
                            <img id="modal-profile-image" src="{{ $user->image ?? asset('images/default-avatar.png') }}"
                                alt="Profile" class="h-24 w-24 rounded-full border-4 border-white object-cover mx-auto">
                            <label for="modal-image-upload"
                                class="absolute bottom-0 right-0 bg-accent hover:bg-accentHover text-white rounded-full p-2 cursor-pointer shadow-lg">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="modal-image-upload" name="image" class="hidden">
                        </div>
                    </div>

                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->first_name }}">
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->last_name }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->email }}">
                    </div>

                    <div>
                        <label for="speciality" class="block text-sm font-medium text-gray-500 mb-1">Speciality</label>
                        <input type="text" id="speciality" name="speciality"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->doctor->speciality }}">
                    </div>

                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-500 mb-1">Experience
                            (Years)</label>
                        <input type="number" id="experience" name="experience"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent"
                            value="{{ $user->doctor->experience }}">
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <select id="gender" name="gender"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-accent/20 focus:border-accent">
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-accent hover:bg-accentHover text-white py-2.5 px-4 rounded-lg transition-colors font-medium">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageUpload = document.getElementById('image-upload');
            const profileImage = document.getElementById('profile-image');
            const modalImageUpload = document.getElementById('modal-image-upload');
            const modalProfileImage = document.getElementById('modal-profile-image');

            if (imageUpload && profileImage) {
                imageUpload.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        const src = URL.createObjectURL(e.target.files[0]);
                        profileImage.src = src;
                        if (modalProfileImage) modalProfileImage.src = src;
                    }
                });
            }

            if (modalImageUpload && modalProfileImage) {
                modalImageUpload.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        const src = URL.createObjectURL(e.target.files[0]);
                        modalProfileImage.src = src;
                        if (profileImage) profileImage.src = src;
                    }
                });
            }

            const editProfileBtn = document.getElementById('edit-profile-btn');
            const editProfessionalInfoBtn = document.getElementById('edit-professional-info-btn');
            const editProfileModal = document.getElementById('edit-profile-modal');
            const closeModalBtn = document.getElementById('close-modal');

            if (editProfileBtn && editProfileModal) {
                editProfileBtn.addEventListener('click', function() {
                    editProfileModal.classList.remove('hidden');
                });
            }

            if (editProfessionalInfoBtn && editProfileModal) {
                editProfessionalInfoBtn.addEventListener('click', function() {
                    editProfileModal.classList.remove('hidden');
                });
            }

            if (closeModalBtn && editProfileModal) {
                closeModalBtn.addEventListener('click', function() {
                    editProfileModal.classList.add('hidden');
                });
            }

            window.addEventListener('click', function(e) {
                if (editProfileModal && e.target === editProfileModal) {
                    editProfileModal.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
