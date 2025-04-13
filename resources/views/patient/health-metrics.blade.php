@extends('layouts.patient')

@section('title', 'Health Metrics')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .metric-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-button.active {
            color: #00928C;
            border-bottom: 2px solid #00928C;
        }
    </style>
@endsection

@section('content')
    <div class="container px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Health Metrics</h1>

        <!-- Latest Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Blood Pressure Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden metric-card">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Blood Pressure</h3>
                        <i class="fas fa-heartbeat text-2xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    @if ($latestBloodPressure['exists'] ?? false)
                        <div class="text-3xl font-bold text-gray-800">
                            {{ $latestBloodPressure['systolic'] }}/{{ $latestBloodPressure['diastolic'] }}
                            <span class="text-sm font-normal text-gray-500">mmHg</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Last recorded: {{ $latestBloodPressure['date'] }}</p>
                    @else
                        <div class="text-gray-500 italic">No data available</div>
                    @endif
                </div>
            </div>

            <!-- Blood Sugar Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden metric-card">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Blood Sugar</h3>
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    @if ($latestBloodSugar['exists'] ?? false)
                        <div class="text-3xl font-bold text-gray-800">
                            {{ $latestBloodSugar['value'] }}
                            <span class="text-sm font-normal text-gray-500">mg/dL</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Last recorded: {{ $latestBloodSugar['date'] }}</p>
                    @else
                        <div class="text-gray-500 italic">No data available</div>
                    @endif
                </div>
            </div>

            <!-- Heart Rate Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden metric-card">
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Heart Rate</h3>
                        <i class="fas fa-heart text-2xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    @if ($latestHeartRate['exists'] ?? false)
                        <div class="text-3xl font-bold text-gray-800">
                            {{ $latestHeartRate['value'] }}
                            <span class="text-sm font-normal text-gray-500">bpm</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Last recorded: {{ $latestHeartRate['date'] }}</p>
                    @else
                        <div class="text-gray-500 italic">No data available</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6 bg-white rounded-xl shadow-sm p-1">
            <div class="flex overflow-x-auto">
                <button class="tab-button active px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="all-metrics">
                    All Metrics History
                </button>
                <button class="tab-button px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="blood-pressure">
                    Blood Pressure
                </button>
                <button class="tab-button px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="blood-sugar">
                    Blood Sugar
                </button>
                <button class="tab-button px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="heart-rate">
                    Heart Rate
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <!-- All Metrics Tab -->
        <div id="all-metrics" class="tab-content active">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Recent Measurements</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Metric Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Value
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recorded By
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($healthMetrics as $metric)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($metric['created_at'])->format('M d, Y - h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full 
                                                        @if ($metric['type'] == 'Blood Pressure') bg-blue-100 text-blue-800
                                                        @elseif($metric['type'] == 'Blood Sugar') bg-green-100 text-green-800
                                                        @elseif($metric['type'] == 'Heart Rate') bg-red-100 text-red-800 @endif">
                                            {{ $metric['type'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $metric['value'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $metric['recorded_by'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No health metrics recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Blood Pressure Tab -->
        <div id="blood-pressure" class="tab-content">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Blood Pressure History</h3>
                <div class="h-80">
                    <canvas id="bloodPressureChart"></canvas>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <p><strong>Healthy Range:</strong> 90-120/60-80 mmHg</p>
                    <p class="mt-1"><i class="fas fa-info-circle text-blue-500"></i> Blood pressure is measured in
                        millimeters of mercury (mmHg) and is written as systolic/diastolic pressure.</p>
                </div>
            </div>
        </div>

        <!-- Blood Sugar Tab -->
        <div id="blood-sugar" class="tab-content">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Blood Sugar History</h3>
                <div class="h-80">
                    <canvas id="bloodSugarChart"></canvas>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <p><strong>Normal Range:</strong> 70-99 mg/dL (fasting)</p>
                    <p class="mt-1"><i class="fas fa-info-circle text-green-500"></i> Blood sugar levels are important
                        indicators for diabetes management and overall health.</p>
                </div>
            </div>
        </div>

        <!-- Heart Rate Tab -->
        <div id="heart-rate" class="tab-content">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Heart Rate History</h3>
                <div class="h-80">
                    <canvas id="heartRateChart"></canvas>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <p><strong>Normal Resting Heart Rate:</strong> 60-100 beats per minute (bpm)</p>
                    <p class="mt-1"><i class="fas fa-info-circle text-red-500"></i> Your heart rate can vary throughout
                        the day based on activity, stress levels, and other factors.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    button.classList.add('active');
                    const tabId = button.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });

            const bpCtx = document.getElementById('bloodPressureChart').getContext('2d');
            const bpChart = new Chart(bpCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($bloodPressureChartData['labels'] ?? []) !!},
                    datasets: [{
                            label: 'Systolic',
                            data: {!! json_encode($bloodPressureChartData['systolic'] ?? []) !!},
                            borderColor: 'rgba(59, 130, 246, 1)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: 'Diastolic',
                            data: {!! json_encode($bloodPressureChartData['diastolic'] ?? []) !!},
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'mmHg'
                            },
                            min: 40,
                            max: 200
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });

            const bsCtx = document.getElementById('bloodSugarChart').getContext('2d');
            const bsChart = new Chart(bsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($bloodSugarChartData['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Blood Sugar',
                        data: {!! json_encode($bloodSugarChartData['values'] ?? []) !!},
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'mg/dL'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });

            const hrCtx = document.getElementById('heartRateChart').getContext('2d');
            const hrChart = new Chart(hrCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($heartRateChartData['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Heart Rate',
                        data: {!! json_encode($heartRateChartData['values'] ?? []) !!},
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'BPM'
                            },
                            min: 40,
                            max: 180
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
