<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') - HealthGate Doctor Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script>
              tailwind.config = {
                            theme: {
                                          fontFamily: {
                                                        sans: ['Poppins', 'sans-serif'],
                                                        },
                                                                      extend: {
                                                                                    colors: {
                                                                                                  primary: '#F8F8F8',
                                                                                                  secondary: '#FFFFFF',
                                                                                                  accent: '#00928C',
                                                                                                  accentHover: '#007A75',
                                                                                                  darkTeal: '#007A75',
                                                                                                  lightGray: '#F0F0F0',
                                                                                                  sidebarBg: '#FFFFFF',
                                                                                                  sidebarHover: '#F5F5F5',
                                                                                                  cardBg: 'rgba(255, 255, 255, 0.8)'
                                                                                    },
                                                                                    boxShadow: {
                                                                                                  'card': '0 4px 15px rgba(0, 0, 0, 0.05)',
                                                                                                  'sidebar': '0 0 20px rgba(0, 0, 0, 0.05)',
                                                                                                  'nav': '0 2px 10px rgba(0, 0, 0, 0.05)',
                                                                                    },
                                                                      }
                                                        }
                                          }
</script>
<style>
              body {
              font-family: 'Poppins', sans-serif;
              }

              .sidebar-link {
              transition: all 0.3s ease;
              position: relative;
              overflow: hidden;
              }

              .sidebar-link::after {
              content: '';
              position: absolute;
              left: 0;
              bottom: 0;
              height: 0;
              width: 4px;
              background-color: theme('colors.accent');
              transition: height 0.3s ease;
              }

              .sidebar-link:hover {
              background-color: theme('colors.sidebarHover');
              transform: translateX(4px);
              }

              .sidebar-link:hover::after {
              height: 100%;
              }

              .sidebar-link.active {
              border-left: 4px solid theme('colors.accent');
              background-color: rgba(0, 146, 140, 0.15);
              font-weight: 500;
              }

              .sidebar-link.active i {
              color: theme('colors.accent');
              }

              .card-animate {
              transition: all 0.3s ease;
              }

              .card-animate:hover {
              transform: translateY(-5px);
              box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
              }

              /* Custom scrollbar */
              ::-webkit-scrollbar {
              width: 1px;
              }

              ::-webkit-scrollbar-track {
              background: #f1f1f1;
              border-radius: 8px;
              }

              ::-webkit-scrollbar-thumb {
              background: #bbb;
              border-radius: 8px;
              }

              ::-webkit-scrollbar-thumb:hover {
              background: #888;
              }

              /* Notification badge animation */
              @keyframes pulse {
              0% { transform: scale(0.95); opacity: 0.9; }
              50% { transform: scale(1.05); opacity: 1; }
              100% { transform: scale(0.95); opacity: 0.9; }
              }

              .notification-badge {
              animation: pulse 1.5s infinite;
              }

              /* Fixed sidebar with scrolling */
              #sidebar {
              height: 100vh;
              overflow-y: auto;
              }

              /* Responsive sidebar adjustments */
              @media (max-width: 768px) {
              #sidebar {
              transform: translateX(-100%);
              transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
              box-shadow: none;
              }

              #sidebar.open {
              transform: translateX(0);
              box-shadow: 5px 0 25px rgba(0,0,0,0.15);
              }

              #content {
              margin-left: 0;
              width: 100%;
              transition: margin-left 0.3s ease;
              }

              .overlay {
              opacity: 0;
              visibility: hidden;
              transition: opacity 0.3s ease;
              }

              .overlay.active {
              opacity: 1;
              visibility: visible;
              }
              }

              .stat-card {
              background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
              border-radius: 12px;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
              border-left: 4px solid theme('colors.accent');
              transition: all 0.3s ease;
              }

              .stat-card:hover {
              transform: translateY(-5px);
              box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
              }

              .chart-container {
              transition: all 0.3s ease;
              border-radius: 12px;
              overflow: hidden;
              }

              .tooltip {
              position: relative;
              display: inline-block;
              }

              .tooltip .tooltip-text {
              visibility: hidden;
              background-color: #333;
              color: #fff;
              text-align: center;
              border-radius: 6px;
              padding: 5px;
              position: absolute;
              z-index: 1;
              bottom: 125%;
              left: 50%;
              transform: translateX(-50%);
              opacity: 0;
              transition: opacity 0.3s;
              }

              .tooltip:hover .tooltip-text {
              visibility: visible;
              opacity: 1;
              }
</style>
@yield('styles')
</head>
<body class="bg-gradient-to-br from-primary to-lightGray text-gray-800">
<div class="flex h-screen overflow-hidden relative">
<!-- Dark overlay for mobile -->
<div id="overlay" class="overlay fixed inset-0 bg-black bg-opacity-50 z-10 hidden md:hidden"></div>

<!-- Sidebar -->
<div id="sidebar" class="bg-sidebarBg text-gray-800 w-64 space-y-6 py-5 px-3 fixed inset-y-0 left-0 transform md:relative md:translate-x-0 transition duration-200 ease-in-out z-20 shadow-sidebar">
<!-- Logo -->
<div class="flex items-center justify-center space-x-2 px-4 py-2">
<div class="h-10 w-10 rounded-full bg-accent flex items-center justify-center">
<i class="fas fa-heartbeat text-xl text-white"></i>
</div>
<span class="text-2xl font-bold">Health<span class="text-accent">Gate</span></span>
</div>

<!-- Doctor Info -->
<div class="mx-4 p-4 mb-6 rounded-xl bg-gradient-to-r from-gray-100 to-white shadow-md">
<div class="flex items-center space-x-3">
<div class="h-12 w-12 rounded-full bg-accent bg-opacity-20 flex items-center justify-center p-1 ring-2 ring-accent overflow-hidden">
@if($user->image)
<img src="{{ $user->image }}" alt="Doctor's photo" class="h-full w-full object-cover rounded-full">
@else
<i class="fas fa-user-md text-accent"></i>
@endif
</div>
<div>
<h3 class="text-sm font-semibold text-gray-800">Dr. {{ $user->first_name }} {{ $user->last_name }}</h3>
<p class="text-xs text-gray-500">{{ $user->doctor->speciality ?? 'Medical Doctor' }}</p>
</div>
</div>
<div class="mt-3 pt-3 border-t border-gray-200 text-xs">
<p class="text-gray-600 flex items-center">
<i class="fas fa-circle text-green-400 mr-1 text-xs"></i> Online
</p>
</div>
</div>

<!-- Nav Links -->
<nav class="px-3 space-y-1">
<p class="text-xs text-gray-500 px-3 uppercase tracking-wider mb-2">Main Menu</p>

<a href="{{ route('doctor.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
<i class="fas fa-chart-line w-5 text-center"></i>
<span>Dashboard</span>
</a>

<a href="{{ route('doctor.appointments') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.appointments*') ? 'active' : '' }}">
<i class="fas fa-calendar-check w-5 text-center"></i>
<span>Appointments</span>
<span class="ml-auto bg-accent text-white text-xs px-2 py-0.5 rounded-full">
{{ \App\Models\Appointment::where('doctor_id', $user->doctor->id ?? 0)->where('status', 'pending')->count() ?? '0' }}
</span>
</a>

<p class="text-xs text-gray-500 px-3 uppercase tracking-wider mb-2 mt-6">Patient Management</p>

<a href="{{ route('doctor.patients') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.patients*') ? 'active' : '' }}">
<i class="fas fa-users w-5 text-center"></i>
<span>My Patients</span>
</a>

<a href="{{ route('doctor.medical-records') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.medical-records*') ? 'active' : '' }}">
<i class="fas fa-file-medical w-5 text-center"></i>
<span>Medical Records</span>
</a>

<a href="{{ route('doctor.prescriptions') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.prescriptions*') ? 'active' : '' }}">
<i class="fas fa-prescription w-5 text-center"></i>
<span>Prescriptions</span>
</a>

<p class="text-xs text-gray-500 px-3 uppercase tracking-wider mb-2 mt-6">Medical Resources</p>

<a href="{{ route('doctor.diseases') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.diseases*') ? 'active' : '' }}">
<i class="fas fa-disease w-5 text-center"></i>
<span>Diseases Library</span>
</a>

<a href="{{ route('doctor.health-metrics') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.health-metrics*') ? 'active' : '' }}">
<i class="fas fa-heartbeat w-5 text-center"></i>
<span>Health Metrics</span>
</a>

<p class="text-xs text-gray-500 px-3 uppercase tracking-wider mb-2 mt-6">Personal</p>

<a href="{{ route('doctor.schedule') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.schedule*') ? 'active' : '' }}">
<i class="fas fa-clock w-5 text-center"></i>
<span>My Schedule</span>
</a>

<a href="{{ route('doctor.profile') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.profile*') ? 'active' : '' }}">
<i class="fas fa-user-md w-5 text-center"></i>
<span>My Profile</span>
</a>

<a href="{{ route('doctor.settings') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('doctor.settings*') ? 'active' : '' }}">
<i class="fas fa-cog w-5 text-center"></i>
<span>Settings</span>
</a>

<div class="pt-6 border-t border-gray-200 mt-6">
<form method="POST" action="{{ route('logout') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-link hover:bg-red-100 group">
@csrf
<i class="fas fa-sign-out-alt w-5 text-center text-red-500"></i>
<button type="submit" class="w-full text-left focus:outline-none text-red-500">Logout</button>
</form>
</div>
</nav>

<!-- Help section -->
<div class="px-4 mt-6">
<div class="bg-accent bg-opacity-10 p-4 rounded-lg">
<h4 class="text-sm font-medium text-accent mb-2">Need Help?</h4>
<p class="text-xs text-gray-600 mb-3">Get assistance with the doctor portal</p>
<a href="#" class="text-xs bg-accent hover:bg-accentHover text-white py-2 px-3 rounded-lg inline-block transition-colors duration-200">
<i class="fas fa-headset mr-1"></i> Support Center
</a>
</div>
</div>
</div>

<!-- Content -->
<div id="content" class="flex-1 overflow-y-auto">
<!-- Top Navigation -->
<div class="bg-white shadow-nav sticky top-0 z-10">
<div class="flex items-center justify-between px-6 py-4">
<!-- Mobile menu button -->
<button id="menu-btn" class="md:hidden focus:outline-none flex items-center justify-center h-10 w-10 rounded-lg hover:bg-gray-100">
<i class="fas fa-bars text-gray-700"></i>
</button>

<!-- Page title -->
<h1 class="text-xl font-semibold text-gray-800 hidden md:block">@yield('page-title', 'Doctor Dashboard')</h1>

<!-- Search bar - visible on larger screens -->
<div class="hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 flex-1 max-w-md mx-4">
<i class="fas fa-search text-gray-500 mr-2"></i>
<input type="text" placeholder="Search patients, appointments..." class="bg-transparent border-none focus:outline-none text-sm flex-1">
</div>

<!-- Right side elements - Notifications, etc. -->
<div class="flex items-center space-x-4">
<div class="relative">
<button class="text-gray-600 hover:text-accent focus:outline-none h-10 w-10 rounded-full flex items-center justify-center hover:bg-gray-100">
<i class="fas fa-bell"></i>
<span class="notification-badge absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
</button>
</div>

<div class="relative">
<button class="text-gray-600 hover:text-accent focus:outline-none h-10 w-10 rounded-full flex items-center justify-center hover:bg-gray-100">
<i class="fas fa-envelope"></i>
<span class="notification-badge absolute top-1 right-1 h-2 w-2 bg-accent rounded-full"></span>
</button>
</div>

<div class="h-10 w-px bg-gray-200 mx-1"></div>

<!-- User dropdown -->
<div class="relative">
<button id="user-menu-btn" class="flex items-center space-x-2 focus:outline-none">
<div class="h-10 w-10 rounded-full bg-accent bg-opacity-20 flex items-center justify-center overflow-hidden">
@if($user->image)
<img src="{{ $user->image }}" class="h-full w-full object-cover" alt="Doctor Photo">
@else
<span class="font-medium text-accent">{{ substr($user->first_name, 0, 1) }}</span>
@endif
</div>
<div class="hidden md:block text-left">
<span class="block text-sm font-medium">Dr. {{ $user->first_name ?? 'Guest User' }}</span>
<span class="block text-xs text-gray-500">{{ $user->doctor->speciality ?? 'Doctor' }}</span>
</div>
<i class="fas fa-chevron-down text-xs text-gray-500 hidden md:block"></i>
</button>

<!-- Dropdown menu (hidden by default) -->
<div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-20 hidden">
<a href="{{ route('doctor.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
<i class="fas fa-user-md mr-2"></i> My Profile
</a>
<a href="{{ route('doctor.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
<i class="fas fa-cog mr-2"></i> Settings
</a>
<div class="border-t border-gray-100 my-1"></div>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
<i class="fas fa-sign-out-alt mr-2"></i> Logout
</button>
</form>
</div>
</div>
</div>
</div>

<!-- Mobile search - visible only on mobile -->
<div class="px-4 pb-3 md:hidden">
<div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
<i class="fas fa-search text-gray-500 mr-2"></i>
<input type="text" placeholder="Search..." class="bg-transparent border-none focus:outline-none text-sm flex-1">
</div>
</div>

<!-- Breadcrumbs -->
<div class="px-6 py-2 bg-gray-50 text-xs text-gray-500 flex items-center space-x-2">
<a href="{{ route('doctor.dashboard') }}" class="hover:text-accent">Home</a>
<i class="fas fa-chevron-right text-xs"></i>
<span>@yield('breadcrumb', 'Dashboard')</span>
</div>
</div>

{{-- Flash messages --}}
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-6" role="alert">
<span class="block sm:inline">{{ session('success') }}</span>
<span class="absolute top-0 bottom-0 right-0 px-4 py-3">
<svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
<title>Close</title>
<path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
</svg>
</span>
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-6" role="alert">
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
<span class="absolute top-0 bottom-0 right-0 px-4 py-3">
<svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
<title>Close</title>
<path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
</svg>
</span>
</div>
@endif

<!-- Main Content -->
<div class="p-6">
@yield('content')
</div>

<!-- Footer -->
<footer class="bg-white p-6 text-center text-sm text-gray-600 border-t">
<div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center">
<div class="mb-4 md:mb-0">
<p>&copy; {{ date('Y') }} HealthGate. All rights reserved.</p>
</div>
<div class="flex items-center space-x-4">
<a href="#" class="text-gray-500 hover:text-accent">Privacy Policy</a>
<a href="#" class="text-gray-500 hover:text-accent">Terms of Service</a>
<a href="#" class="text-gray-500 hover:text-accent">Contact</a>
</div>
</div>
</footer>
</div>
</div>

<!-- Scripts -->
<script>
// Mobile sidebar toggle
document.getElementById('menu-btn').addEventListener('click', function() {
document.getElementById('sidebar').classList.toggle('open');
document.getElementById('overlay').classList.toggle('active');
document.getElementById('overlay').classList.toggle('hidden');
});

// Close sidebar when clicking on overlay
document.getElementById('overlay').addEventListener('click', function() {
document.getElementById('sidebar').classList.remove('open');
document.getElementById('overlay').classList.remove('active');
document.getElementById('overlay').classList.add('hidden');
});

// User dropdown toggle
const userMenuBtn = document.getElementById('user-menu-btn');
const userDropdown = document.getElementById('user-dropdown');

if (userMenuBtn && userDropdown) {
userMenuBtn.addEventListener('click', function() {
userDropdown.classList.toggle('hidden');
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
if (!userMenuBtn.contains(event.target) && !userDropdown.contains(event.target)) {
userDropdown.classList.add('hidden');
}
});
}

// Add card animation class to all cards created in content section
document.addEventListener('DOMContentLoaded', function() {
const cards = document.querySelectorAll('.card');
cards.forEach(card => {
card.classList.add('card-animate');
});

// Dismiss alerts after 5 seconds
setTimeout(function() {
const alerts = document.querySelectorAll('[role="alert"]');
alerts.forEach(alert => {
alert.style.opacity = '0';
alert.style.transition = 'opacity 0.5s ease';
setTimeout(() => {
alert.style.display = 'none';
}, 500);
});
}, 5000);
});

// Close alert when clicking on the X
document.addEventListener('click', function(event) {
if (event.target.closest('[role="alert"] svg')) {
const alert = event.target.closest('[role="alert"]');
alert.style.opacity = '0';
alert.style.transition = 'opacity 0.5s ease';
setTimeout(() => {
alert.style.display = 'none';
}, 500);
}
});
</script>
@yield('scripts')
</body>
</html>