<!DOCTYPE html>
<html lang="en">
<head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>@yield('title') - HealthGate Test Dashboard</title>
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
                                          
                                          <!-- User Info -->
                                          <div class="mx-4 p-4 mb-6 rounded-xl bg-gradient-to-r from-gray-100 to-white shadow-md">
                                                        <div class="flex items-center space-x-3">
                                                                      <div class="h-12 w-12 rounded-full bg-accent bg-opacity-20 flex items-center justify-center p-1 ring-2 ring-accent overflow-hidden">
                                                                                    @if(isset($user) && $user->image)
                                                                                                  <img src="{{ $user->image }}" alt="{{ $user->first_name }}'s photo" class="h-full w-full object-cover rounded-full">
                                                                                    @else
                                                                                                  <i class="fas fa-user text-accent"></i>
                                                                                    @endif
                                                                      </div>
                                                                      <div>
                                                                                    <h3 class="text-sm font-semibold text-gray-800">{{ $user->first_name ?? 'User' }} {{ $user->last_name ?? '' }}</h3>
                                                                                    <p class="text-xs text-gray-500">ID: #{{ $user->id ?? '000' }}</p>
                                                                      </div>
                                                        </div>
                                                        <div class="mt-3 pt-3 border-t border-gray-200 text-xs">
                                                                      <p class="text-gray-600 flex items-center">
                                                                                    <i class="fas fa-circle text-green-400 mr-1 text-xs"></i> Active Account
                                                                      </p>
                                                        </div>
                                          </div>
                                          
                                          <!-- Nav Links -->
                                          <nav class="px-3 space-y-1">
                                                        <p class="text-xs text-gray-500 px-3 uppercase tracking-wider mb-2">Main Menu</p>
                                                        
                                                        <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                                                      <i class="fas fa-home w-5 text-center"></i>
                                                                      <span>Dashboard</span>
                                                        </a>
                                                        
                                                        <a href="{{ route('appointments') }}" class="sidebar-link flex items-