<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HealthGate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F8F8F8', // White/Off-white
                        secondary: '#FFFFFF', // White
                        accent: '#00928C', // Teal
                        darkTeal: '#007A75', // Dark Teal
                        lightGray: '#F0F0F0' // Light Gray
                    }
                }
            }
        }
    </script>
    <style>
        .step-active {
            border-color: #00928C;
        }
        .form-appear {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-input {
            @apply mt-1 block w-full rounded-md bg-white border-gray-300 shadow-sm text-gray-800 px-4 py-3 transition duration-300 ease-in-out;
        }
        .form-input:focus {
            @apply border-accent ring ring-accent ring-opacity-30 outline-none;
            box-shadow: 0 0 0 2px rgba(0, 146, 140, 0.2);
        }
        .input-error {
            @apply border-red-500 ring ring-red-500 ring-opacity-50;
        }
        .side-image-overlay {
            background: linear-gradient(to bottom, rgba(0, 146, 140, 0.7), rgba(0, 122, 117, 0.8));
        }
    </style>
</head>
<body class="bg-primary text-gray-800 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <span class="text-gray-800 text-2xl font-bold">Health<span class="text-accent">Gate</span></span>
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-accent px-3 py-2 rounded-md text-sm font-medium">
                        Already have an account? Log in
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full bg-secondary rounded-xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="hidden md:block md:w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                    <div class="absolute inset-0 side-image-overlay"></div>
                    <div class="relative h-full p-10 flex flex-col justify-between z-10">
                        <div>
                            <h2 class="text-white text-3xl font-bold mb-6">Join HealthGate</h2>
                            <p class="text-white opacity-90">
                                Create your account and start managing your healthcare journey with just a few clicks.
                            </p>
                        </div>
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-4">
                                    <i class="fas fa-user-md text-white"></i>
                                </div>
                                <p class="text-white">Access to qualified healthcare professionals</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-4">
                                    <i class="fas fa-calendar-check text-white"></i>
                                </div>
                                <p class="text-white">Book appointments easily</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-4">
                                    <i class="fas fa-file-medical text-white"></i>
                                </div>
                                <p class="text-white">Manage your health records</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-6 md:p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">Create Your Account</h2>
                        <p class="text-gray-600 mt-2">Fill out the form to get started</p>
                    </div>

                    <!-- Progress Steps -->
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex flex-col items-center">
                            <div id="step1-indicator" class="w-8 h-8 bg-white step-active border-2 rounded-full flex items-center justify-center text-accent font-bold">1</div>
                            <span class="text-xs mt-1 text-gray-600">Account</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div id="step2-indicator" class="w-8 h-8 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">2</div>
                            <span class="text-xs mt-1 text-gray-600">Personal</span>
                        </div>
                    </div>

                    <!-- Form with improved structure and styling -->
                    <form action="{{ route('register') }}" method="POST" id="registration-form" class="w-full">
                        @csrf
                        <input type="hidden" name="role" value="patient">

                        <!-- Step 1: Account Information -->
                        <div id="step1" class="space-y-6 form-appear">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                            <i class="fas fa-user text-sm"></i>
                                        </span>
                                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                                            class="w-full py-2.5 pl-10 pr-3 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('first_name') border-red-500 @enderror"
                                            placeholder="John">
                                    </div>
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                            <i class="fas fa-user text-sm"></i>
                                        </span>
                                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                            class="w-full py-2.5 pl-10 pr-3 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('last_name') border-red-500 @enderror"
                                            placeholder="Doe">
                                    </div>
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="w-full py-2.5 pl-10 pr-3 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('email') border-red-500 @enderror"
                                        placeholder="your.email@example.com">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                        <i class="fas fa-lock text-sm"></i>
                                    </span>
                                    <input type="password" id="password" name="password" required
                                        class="w-full py-2.5 pl-10 pr-3 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('password') border-red-500 @enderror"
                                        placeholder="Minimum 8 characters">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-xs mt-1 italic">Must contain at least 8 characters</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                        <i class="fas fa-shield-alt text-sm"></i>
                                    </span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="w-full py-2.5 pl-10 pr-3 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200"
                                        placeholder="Re-enter your password">
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="button" id="next-btn" 
                                    class="w-full bg-gradient-to-r from-accent to-darkTeal text-white font-medium py-3 px-4 rounded-lg shadow-lg hover:shadow-accent/50 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-gray-100 transition-all duration-300 transform hover:-translate-y-0.5">
                                    Continue to Personal Information <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Personal Information -->
                        <div id="step2" class="hidden space-y-6 form-appear">
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                        <i class="fas fa-venus-mars text-sm"></i>
                                    </span>
                                    <select id="gender" name="gender" required
                                        class="w-full py-2.5 pl-10 pr-10 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm appearance-none transition-all duration-200 @error('gender') border-red-500 @enderror">
                                        <option value="" disabled selected>Select your gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </span>
                                </div>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                        <i class="fas fa-birthday-cake text-sm"></i>
                                    </span>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                        class="w-full py-2.5 pl-10 pr-3 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('date_of_birth') border-red-500 @enderror">
                                </div>
                                @error('date_of_birth')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                            <i class="fas fa-ruler-vertical text-sm"></i>
                                        </span>
                                        <input type="number" id="height" name="height" value="{{ old('height') }}" min="50" max="250"
                                            class="w-full py-2.5 pl-10 pr-10 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('height') border-red-500 @enderror"
                                            placeholder="175">
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                            cm
                                        </span>
                                    </div>
                                    @error('height')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                            <i class="fas fa-weight text-sm"></i>
                                        </span>
                                        <input type="number" id="weight" name="weight" value="{{ old('weight') }}" step="0.1" min="20" max="300"
                                            class="w-full py-2.5 pl-10 pr-10 bg-white/50 rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('weight') border-red-500 @enderror"
                                            placeholder="70.5">
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                            kg
                                        </span>
                                    </div>
                                    @error('weight')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex space-x-4 pt-6">
                                <button type="button" id="prev-btn" 
                                    class="w-1/3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-lg border border-gray-300 shadow focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button type="submit" 
                                    class="w-2/3 bg-gradient-to-r from-accent to-darkTeal text-white font-medium py-3 px-4 rounded-lg shadow-lg hover:shadow-accent/50 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-white transition-all duration-300 transform hover:-translate-y-0.5">
                                    Complete Registration <i class="fas fa-check-circle ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm">
                        <p class="text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-accent hover:text-darkTeal">
                                Sign in
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow-inner py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-600 text-sm">
                © 2023 HealthGate. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Multi-step form handling
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const nextBtn = document.getElementById('next-btn');
        const prevBtn = document.getElementById('prev-btn');
        const step1Indicator = document.getElementById('step1-indicator');
        const step2Indicator = document.getElementById('step2-indicator');

        // Handle form navigation
        nextBtn.addEventListener('click', function() {
            // Validate step 1 fields
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            let isValid = true;
            let errorMessage = "";
            
            if (!firstName) {
                isValid = false;
                errorMessage = "First name is required";
            } else if (!lastName) {
                isValid = false;
                errorMessage = "Last name is required";
            } else if (!email) {
                isValid = false;
                errorMessage = "Email is required";
            } else if (!validateEmail(email)) {
                isValid = false;
                errorMessage = "Please enter a valid email address";
            } else if (!password) {
                isValid = false;
                errorMessage = "Password is required";
            } else if (password.length < 8) {
                isValid = false;
                errorMessage = "Password must be at least 8 characters";
            } else if (password !== passwordConfirmation) {
                isValid = false;
                errorMessage = "Passwords do not match";
            }
            
            if (!isValid) {
                alert(errorMessage);
                return;
            }
            
            // Move to step 2
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            step1Indicator.classList.remove('step-active');
            step2Indicator.classList.add('step-active');
        });

        prevBtn.addEventListener('click', function() {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            step2Indicator.classList.remove('step-active');
            step1Indicator.classList.add('step-active');
        });

        // Email validation helper
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
</body>
</html>