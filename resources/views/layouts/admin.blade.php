<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HealthGate Admin Dashboard</title>
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
                        primary: '#121212',
                        secondary: '#1E1E1E',
                        accent: '#00A99D',
                        accentHover: '#008F84',
                        darkText: '#E2E2E2',
                        lightText: '#A0A0A0',
                        sidebarBg: '#1A1A1A',
                        sidebarHover: '#2C2C2C',
                        cardBg: '#252525',
                        borderColor: '#333333'
                    },
                    boxShadow: {
                        'card': '0 4px 15px rgba(0, 0, 0, 0.2)',
                        'sidebar': '0 0 20px rgba(0, 0, 0, 0.3)',
                        'nav': '0 2px 10px rgba(0, 0, 0, 0.2)',
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #E2E2E2;
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
            background-color: rgba(0, 169, 157, 0.2);
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 2px;
        }

        ::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Notification badge animation */
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 0.9;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(0.95);
                opacity: 0.9;
            }
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
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.3);
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
            background: linear-gradient(135deg, #252525 0%, #1E1E1E 100%);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-left: 4px solid theme('colors.accent');
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
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
            background-color: #444;
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

<body class="bg-primary text-darkText">
    <div class="flex h-screen overflow-hidden relative">
        <div id="overlay" class="overlay fixed inset-0 bg-black bg-opacity-70 z-10 hidden md:hidden"></div>

        <!-- Sidebar -->
        <div id="sidebar"
            class="bg-sidebarBg text-darkText w-64 space-y-6 py-5 px-3 fixed inset-y-0 left-0 transform md:relative md:translate-x-0 transition duration-200 ease-in-out z-20 shadow-sidebar">
            <div class="flex items-center justify-center space-x-2 px-4 py-2">
                <div class="h-10 w-10 rounded-full bg-accent flex items-center justify-center">
                    <i class="fas fa-heartbeat text-xl text-white"></i>
                </div>
                <span class="text-2xl font-bold text-darkText">Health<span class="text-accent">Gate</span></span>
            </div>
            <div class="mx-4 p-4 mb-6 rounded-xl bg-gradient-to-r from-cardBg to-secondary shadow-md border border-borderColor">
                <div class="flex items-center space-x-3">
                    <div
                        class="h-12 w-12 rounded-full bg-accent bg-opacity-20 flex items-center justify-center p-1 ring-2 ring-accent overflow-hidden">
                        @if ($user->image)
                            <img src="{{ $user->image }}" alt="Admin's photo"
                                class="h-full w-full object-cover rounded-full">
                        @else
                            <i class="fas fa-user-shield text-accent"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-darkText">{{ $user->first_name }}
                            {{ $user->last_name }}</h3>
                        <p class="text-xs text-lightText">Administrator</p>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-borderColor text-xs">
                    <p class="text-lightText flex items-center">
                        <i class="fas fa-circle text-green-400 mr-1 text-xs"></i> System Administrator
                    </p>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="px-3 space-y-1">
                <p class="text-xs text-lightText px-3 uppercase tracking-wider mb-2">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <p class="text-xs text-lightText px-3 uppercase tracking-wider mb-2 mt-6">User Management</p>

                <a href="{{ route('admin.users') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Users</span>
                </a>

                <p class="text-xs text-lightText px-3 uppercase tracking-wider mb-2 mt-6">Medical Resources</p>

                <a href="{{ route('admin.diseases') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.diseases*') ? 'active' : '' }}">
                    <i class="fas fa-disease w-5 text-center"></i>
                    <span>Diseases Library</span>
                </a>

                <a href="{{ route('admin.departments') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.departments*') ? 'active' : '' }}">
                    <i class="fas fa-hospital-alt w-5 text-center"></i>
                    <span>Departments</span>
                </a>

                <p class="text-xs text-lightText px-3 uppercase tracking-wider mb-2 mt-6">System</p>

                <a href="{{ route('admin.settings') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span>Settings</span>
                </a>

                <div class="pt-6 border-t border-borderColor mt-6">
                    <a href="{{ route('logout') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-link hover:bg-red-900 hover:bg-opacity-30 group">
                        <i class="fas fa-sign-out-alt w-5 text-center text-red-400"></i>
                        <span class="text-red-400">Logout</span>
                    </a>
                </div>
            </nav>

            <!-- Help section -->
            <div class="px-4 mt-6">
                <div class="bg-accent bg-opacity-10 p-4 rounded-lg border border-accent border-opacity-30">
                    <h4 class="text-sm font-medium text-accent mb-2">Admin Support</h4>
                    <p class="text-xs text-lightText mb-3">Access system documentation and help</p>
                    <a href="#"
                        class="text-xs bg-accent hover:bg-accentHover text-white py-2 px-3 rounded-lg inline-block transition-colors duration-200">
                        <i class="fas fa-book mr-1"></i> View Docs
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="content" class="flex-1 overflow-y-auto">
            <!-- Top Navigation -->
            <div class="bg-secondary shadow-nav sticky top-0 z-10 border-b border-borderColor">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile menu button -->
                    <button id="menu-btn"
                        class="md:hidden focus:outline-none flex items-center justify-center h-10 w-10 rounded-lg hover:bg-sidebarHover">
                        <i class="fas fa-bars text-darkText"></i>
                    </button>

                    <!-- Page title -->
                    <h1 class="text-xl font-semibold text-darkText hidden md:block">@yield('page-title', 'Admin Dashboard')</h1>

                    <!-- Search bar - visible on larger screens -->
                    <div class="hidden md:flex items-center bg-primary rounded-lg px-3 py-2 flex-1 max-w-md mx-4 border border-borderColor">
                        <i class="fas fa-search text-lightText mr-2"></i>
                        <input type="text" placeholder="Search..."
                            class="bg-transparent border-none focus:outline-none text-sm flex-1 text-darkText placeholder-lightText">
                    </div>

                    <!-- Right side elements - Notifications, etc. -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button
                                class="text-lightText hover:text-accent focus:outline-none h-10 w-10 rounded-full flex items-center justify-center hover:bg-sidebarHover">
                                <i class="fas fa-bell"></i>
                                <span
                                    class="notification-badge absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>

                        <div class="relative">
                            <button
                                class="text-lightText hover:text-accent focus:outline-none h-10 w-10 rounded-full flex items-center justify-center hover:bg-sidebarHover">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>

                        <div class="h-10 w-px bg-borderColor mx-1"></div>

                        <!-- User dropdown -->
                        <div class="relative">
                            <button id="user-menu-btn" class="flex items-center space-x-2 focus:outline-none">
                                <div
                                    class="h-10 w-10 rounded-full bg-accent bg-opacity-20 flex items-center justify-center overflow-hidden">
                                    @if ($user->image)
                                        <img src="{{ $user->image }}" class="h-full w-full object-cover"
                                            alt="Admin Photo">
                                    @else
                                        <span
                                            class="font-medium text-accent">{{ substr($user->first_name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="hidden md:block text-left">
                                    <span class="block text-sm font-medium text-darkText">
                                        {{ $user->first_name ?? 'Admin User' }}
                                    </span>
                                    <span class="block text-xs text-lightText">Administrator</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-lightText hidden md:block"></i>
                            </button>

                            <!-- Dropdown menu (hidden by default) -->
                            <div id="user-dropdown"
                                class="absolute right-0 mt-2 w-48 bg-secondary rounded-lg shadow-lg py-1 z-20 hidden border border-borderColor">
                                <a href="{{ route('admin.profile') }}"
                                    class="block px-4 py-2 text-sm text-darkText hover:bg-sidebarHover">
                                    <i class="fas fa-user mr-2"></i> My Profile
                                </a>
                                <a href="{{ route('admin.settings') }}"
                                    class="block px-4 py-2 text-sm text-darkText hover:bg-sidebarHover">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <div class="border-t border-borderColor my-1"></div>
                                
                                <a href="{{ route('logout') }}"
                                   class="block px-4 py-2 text-sm text-red-400 hover:bg-sidebarHover">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile search - visible only on mobile -->
                <div class="px-4 pb-3 md:hidden">
                    <div class="flex items-center bg-primary rounded-lg px-3 py-2 border border-borderColor">
                        <i class="fas fa-search text-lightText mr-2"></i>
                        <input type="text" placeholder="Search..."
                            class="bg-transparent border-none focus:outline-none text-sm flex-1 text-darkText placeholder-lightText">
                    </div>
                </div>

                <!-- Breadcrumbs -->
                <div class="px-6 py-2 bg-primary text-xs text-lightText flex items-center space-x-2 border-t border-b border-borderColor">
                    
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-accent">Home</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span>@yield('breadcrumb', 'Dashboard')</span>
                </div>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="bg-green-900 bg-opacity-30 border border-green-600 text-green-200 px-4 py-3 rounded relative m-6"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-900 bg-opacity-30 border border-red-600 text-red-200 px-4 py-3 rounded relative m-6"
                    role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            <!-- Main Content -->
            <div class="p-6">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="bg-secondary p-6 text-center text-sm text-lightText border-t border-borderColor">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p>&copy; {{ date('Y') }} HealthGate. All rights reserved.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-lightText hover:text-accent">Privacy Policy</a>
                        <a href="#" class="text-lightText hover:text-accent">Terms of Service</a>
                        <a href="#" class="text-lightText hover:text-accent">Contact</a>
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
        });
    </script>
    @yield('scripts')
</body>

</html>