<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HealthGate</title>
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
        .form-input {
            @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm text-gray-800 px-4 py-3 transition duration-300 ease-in-out;
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
        .form-appear {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-accent px-3 py-2 rounded-md text-sm font-medium">
                        Don't have an account? Sign up
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full bg-secondary rounded-xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="hidden md:block md:w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1666214280300-24e3dff023e4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                    <div class="absolute inset-0 side-image-overlay"></div>
                    <div class="relative h-full p-10 flex flex-col justify-between z-10">
                        <div>
                            <h2 class="text-white text-3xl font-bold mb-6">Welcome Back</h2>
                            <p class="text-white opacity-90">
                                Log in to your HealthGate account to access your healthcare dashboard and manage your appointments.
                            </p>
                        </div>
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-4">
                                    <i class="fas fa-user-md text-white"></i>
                                </div>
                                <p class="text-white">Connect with healthcare professionals</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-4">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                                <p class="text-white">View your medical history</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-4">
                                    <i class="fas fa-heartbeat text-white"></i>
                                </div>
                                <p class="text-white">Track your health metrics</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-6 md:p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">Log In to Your Account</h2>
                        <p class="text-gray-600 mt-2">Enter your credentials to access your account</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 rounded-lg border border-green-200">
                            <p class="text-green-700 text-sm">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-6 form-appear" >
                        @csrf
                        
                        <div class="space-y-6 form-appear">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="mt-1 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                    <i class="fas fa-envelope text-sm"></i>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full py-2.5 pl-10 pr-3 bg-white rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200 @error('email') border-red-500 @enderror"
                                    placeholder="your.email@example.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div >
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <a href="#" class="text-xs text-accent hover:text-darkTeal">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="mt-1 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-accent">
                                    <i class="fas fa-lock text-sm"></i>
                                </span>
                                <input type="password" id="password" name="password" required
                                    class="w-full py-2.5 pl-10 pr-3 bg-white rounded-lg border border-gray-300 focus:border-accent focus:ring focus:ring-accent/20 text-gray-800 shadow-sm transition-all duration-200"
                                    placeholder="Enter your password">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-accent focus:ring-accent border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <button type="submit" 
                                class="w-full bg-gradient-to-r from-accent to-darkTeal text-white font-medium py-3 px-4 rounded-lg shadow-lg hover:shadow-accent/50 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-primary transition-all duration-300 transform hover:-translate-y-0.5">
                                Sign In <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-s form-appear" >
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-medium text-accent hover:text-darkTeal">
                                Create account
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-600 text-sm">
                © 2023 HealthGate. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>