@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Admin Dashboard')

@section('breadcrumb', 'Dashboard')

@section('content')
<!-- Main Dashboard Content -->
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center">
        <h1 class="text-2xl font-bold text-darkText">Dashboard Overview</h1>
        <div class="flex space-x-2 mt-4 md:mt-0">
            <button class="bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg transition flex items-center space-x-2">
                <i class="fas fa-download"></i>
                <span>Export Report</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Patients Card -->
        <div class="bg-cardBg rounded-xl p-6 shadow-card">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-lightText text-sm">Total Patients</p>
                    <h3 class="text-2xl font-bold mt-1">2,541</h3>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-full">
                    <i class="fas fa-user-injured text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Doctors Card -->
        <div class="bg-cardBg rounded-xl p-6 shadow-card">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-lightText text-sm">Total Doctors</p>
                    <h3 class="text-2xl font-bold mt-1">152</h3>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-full">
                    <i class="fas fa-user-md text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Appointments Card -->
        <div class="bg-cardBg rounded-xl p-6 shadow-card">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-lightText text-sm">Appointments</p>
                    <h3 class="text-2xl font-bold mt-1">485</h3>
                </div>
                <div class="bg-accent/20 p-3 rounded-full">
                    <i class="fas fa-calendar-check text-accent text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Patient Statistics Chart -->
        <div class="bg-cardBg rounded-xl p-6 shadow-card">
            <h3 class="text-lg font-semibold mb-4">Patient Statistics</h3>
            <div class="h-64 flex items-center justify-center">
                <div class="text-center text-lightText">
                    <i class="fas fa-chart-line text-4xl mb-2"></i>
                    <p>Chart will be displayed here</p>
                </div>
            </div>
        </div>

        <!-- Appointment Distribution Chart -->
        <div class="bg-cardBg rounded-xl p-6 shadow-card">
            <h3 class="text-lg font-semibold mb-4">Appointment Distribution</h3>
            <div class="h-64 flex items-center justify-center">
                <div class="text-center text-lightText">
                    <i class="fas fa-chart-pie text-4xl mb-2"></i>
                    <p>Chart will be displayed here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="bg-cardBg rounded-xl p-6 shadow-card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Recent Activities</h3>
            <a href="#" class="text-accent hover:text-accentHover text-sm">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-borderColor">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-lightText tracking-wider">Activity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-lightText tracking-wider">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-lightText tracking-wider">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-lightText tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-lightText tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borderColor">
                    <!-- Activity Row 1 -->
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-blue-500/20 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-plus text-blue-500"></i>
                                </div>
                                <span>New Appointment</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">Sarah Johnson</td>
                        <td class="px-4 py-3 whitespace-nowrap">Dr. Michael Brown</td>
                        <td class="px-4 py-3 whitespace-nowrap">Today, 10:30 AM</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-green-500/20 text-green-500 rounded-full text-xs">Confirmed</span>
                        </td>
                    </tr>
                    <!-- Activity Row 2 -->
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-purple-500/20 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-file-medical text-purple-500"></i>
                                </div>
                                <span>Medical Report</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">John Smith</td>
                        <td class="px-4 py-3 whitespace-nowrap">Dr. Emily Davis</td>
                        <td class="px-4 py-3 whitespace-nowrap">Today, 09:15 AM</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-accent/20 text-accent rounded-full text-xs">Completed</span>
                        </td>
                    </tr>
                    <!-- Activity Row 3 -->
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-red-500/20 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-times text-red-500"></i>
                                </div>
                                <span>Cancelled Appointment</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">Robert Wilson</td>
                        <td class="px-4 py-3 whitespace-nowrap">Dr. Jessica White</td>
                        <td class="px-4 py-3 whitespace-nowrap">Yesterday, 3:00 PM</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-red-500/20 text-red-500 rounded-full text-xs">Cancelled</span>
                        </td>
                    </tr>
                    <!-- Activity Row 4 -->
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-yellow-500/20 h-8 w-8 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user-plus text-yellow-500"></i>
                                </div>
                                <span>New Patient</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">Maria Garcia</td>
                        <td class="px-4 py-3 whitespace-nowrap">-</td>
                        <td class="px-4 py-3 whitespace-nowrap">Yesterday, 11:45 AM</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-500/20 text-blue-500 rounded-full text-xs">New</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Dashboard-specific scripts can be added here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded successfully');
        // You can add chart initializations or other dashboard-specific functionality here
    });
</script>
@endsection