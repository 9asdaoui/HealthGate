@extends('layouts.doctor')

@section('title', 'Patient Medical History')
@section('page-title', 'Patient Medical History')
@section('breadcrumb', 'Patient Medical History')

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
            color: #4F46E5;
            border-bottom: 2px solid #4F46E5;
        }
    </style>
@endsection

@section('content')
    <div class="container px-6 py-4">
        <!-- Patient Overview Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="md:flex">
                <div class="md:w-1/3 bg-gradient-to-br from-indigo-600 to-purple-600 p-6 text-white">
                    <div class="flex items-center mb-4">
                        <div class="h-20 w-20 rounded-full bg-white p-1 mr-4">
                            <img src="{{ $patient->user->image ?? asset('images/default-avatar.jpg') }}"
                                alt="{{ $patient->user->first_name }}" class="h-full w-full object-cover rounded-full">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $patient->user->first_name }} {{ $patient->user->last_name }}
                            </h2>
                            <p class="text-indigo-200">Patient ID: #{{ $patient->id }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div>
                            <p class="text-indigo-200 text-xs">Age</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} years</p>
                        </div>
                        <div>
                            <p class="text-indigo-200 text-xs">Gender</p>
                            <p class="font-medium">{{ ucfirst($patient->gender) }}</p>
                        </div>
                        <div>
                            <p class="text-indigo-200 text-xs">Blood Type</p>
                            <p class="font-medium">{{ $patient->blood_type ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-indigo-200 text-xs">Height / Weight</p>
                            <p class="font-medium">{{ $patient->height ?? '---' }} cm / {{ $patient->weight ?? '---' }} kg
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 md:w-2/3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Patient Information</h3>
                        <div class="flex space-x-2">
                            <a href="#" class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                <i class="fas fa-print mr-1"></i> Print Report
                            </a>
                            <a href="#"
                                class="px-3 py-1 text-xs bg-green-100 text-green-600 rounded hover:bg-green-200">
                                <i class="fas fa-file-export mr-1"></i> Export Data
                            </a>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Contact Information</h4>
                            <p class="mb-1"><i class="fas fa-envelope text-gray-400 mr-2"></i>
                                {{ $patient->user->email }}</p>
                            <p class="mb-1"><i class="fas fa-phone text-gray-400 mr-2"></i>
                                {{ $patient->phone ?? 'No phone number' }}</p>
                            <p><i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                {{ $patient->address ?? 'No address provided' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Emergency Contact</h4>
                            <p class="mb-1"><i class="fas fa-user text-gray-400 mr-2"></i>
                                {{ $patient->emergency_contact_name ?? 'Not provided' }}</p>
                            <p class="mb-1"><i class="fas fa-phone text-gray-400 mr-2"></i>
                                {{ $patient->emergency_contact_phone ?? 'Not provided' }}</p>
                            <p><i class="fas fa-user-friends text-gray-400 mr-2"></i>
                                {{ $patient->emergency_contact_relationship ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Medical Alerts</h4>
                        <div class="flex flex-wrap">

                            @foreach ($patient->diseases as $disease)
                                <span class="m-1 px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs">
                                    <i class="fas fa-disease mr-1"></i> {{ $disease->name }}
                                </span>
                            @endforeach

                            <!-- Additional alerts based on patient's data -->
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Tab Navigation -->
        <div class="mb-6 bg-white rounded-xl shadow-sm p-1">
            <div class="flex overflow-x-auto">
                <button class="tab-button active px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="medical-records">
                    <i class="fas fa-file-medical mr-2"></i> Medical Records
                </button>
                <button class="tab-button px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="health-metrics">
                    <i class="fas fa-chart-line mr-2"></i> Health Metrics
                </button>
                <button class="tab-button px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="diseases">
                    <i class="fas fa-disease mr-2"></i> Diseases
                </button>

                <button class="tab-button px-4 py-3 text-sm font-medium flex-shrink-0" data-tab="appointments">
                    <i class="fas fa-calendar-check mr-2"></i> Appointment History
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <!-- Medical Records Tab -->
        <div id="medical-records" class="tab-content active">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Medical Records</h3>
                <button type="button" data-modal-target="addMedicalRecordModal"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i> Add Medical Record
                </button>
            </div>

            @if (count($medicalRecords) > 0)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Doctor</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Medication</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($medicalRecords as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($record->start_date)->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $record->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Dr.
                                                {{ $record->doctor->user->first_name ?? 'Unknown' }}
                                                {{ $record->doctor->user->last_name ?? '' }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $record->dosage }}
                                                {{ $record->frequency }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                            <button type="button" class="text-blue-600 hover:text-blue-900 mr-3"
                                                data-record-id="{{ $record->id }}"
                                                onclick="editMedicalRecord({{ $record->id }})">
                                                <i class="fas fa-edit">update</i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-3 bg-gray-50 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Showing {{ $medicalRecords->firstItem() ?? 0 }} to {{ $medicalRecords->lastItem() ?? 0 }} of
                            {{ $medicalRecords->total() ?? 0 }} records
                        </div>
                        {{ $medicalRecords->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-file-medical fa-3x"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No medical records</h3>
                    <p class="text-gray-500">This patient doesn't have any medical records yet.</p>
                </div>
            @endif
        </div>

        {{-- Modal for updating Medical Record --}}
        <div id="updateMedicalRecordModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="updateMedicalForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="doctor_id" value="{{ auth()->user()->doctor->id }}">
                        <div class="bg-gray-50 px-4 py-3 border-b">
                            <h3 class="text-lg font-medium text-gray-900">Update Medical Record</h3>
                        </div>

                        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6" id="loadingMedicalRecord">
                            <div class="flex justify-center items-center p-6">
                                <div class="loading-animation">
                                    <div class="animate-pulse flex space-x-4">
                                        <div class="rounded-full bg-indigo-400 h-12 w-12 animate-bounce"></div>
                                        <div class="flex-1 space-y-4 py-1">
                                            <div class="h-4 bg-indigo-400 rounded w-3/4 animate-pulse"></div>
                                            <div class="space-y-2">
                                                <div class="h-4 bg-indigo-300 rounded animate-pulse"></div>
                                                <div class="h-4 bg-indigo-300 rounded w-5/6 animate-pulse"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-center text-indigo-600 font-medium">
                                        <span class="inline-block animate-pulse">Loading medical record...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 hidden" id="medicalRecordFormContent">
                            <div class="mb-4">
                                <label for="update_name" class="block text-sm font-medium text-gray-700">Record
                                    Title</label>
                                <input type="text" name="name" id="update_name"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="mb-4">
                                <label for="update_description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="update_description" rows="3"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="update_dosage" class="block text-sm font-medium text-gray-700">Medication
                                        Dosage</label>
                                    <input type="text" name="dosage" id="update_dosage"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="update_frequency"
                                        class="block text-sm font-medium text-gray-700">Frequency</label>
                                    <input type="text" name="frequency" id="update_frequency"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="update_start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" name="start_date" id="update_start_date"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="update_end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" name="end_date" id="update_end_date"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Update Record
                            </button>
                            <button type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function editMedicalRecord(id) {
                document.getElementById('loadingMedicalRecord').classList.remove('hidden');
                document.getElementById('medicalRecordFormContent').classList.add('hidden');
                // Show the modal
                const modal = document.getElementById('updateMedicalRecordModal');
                modal.classList.remove('hidden');

                // Set the form action URL
                const form = document.getElementById('updateMedicalForm');
                form.action = "{{ route('doctor.medical.update', '') }}/" + id;

                // Fetch the record data and populate the form
                fetch(`/doctor/patients/medical-records/{{ $patient->id }}/edit/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        document.getElementById('update_name').value = data.name;
                        document.getElementById('update_description').value = data.description;
                        document.getElementById('update_dosage').value = data.dosage;
                        document.getElementById('update_frequency').value = data.frequency;

                        // Format dates for input date fields (YYYY-MM-DD)
                        if (data.start_date) {
                            const startDate = new Date(data.start_date);
                            document.getElementById('update_start_date').value = startDate.toISOString().split('T')[0];
                        }

                        if (data.end_date) {
                            const endDate = new Date(data.end_date);
                            document.getElementById('update_end_date').value = endDate.toISOString().split('T')[0];
                        }

                        // Show the form content and hide the loading animation
                        document.getElementById('loadingMedicalRecord').classList.add('hidden');
                        document.getElementById('medicalRecordFormContent').classList.remove('hidden');

                    })
                    .catch(error => {
                        console.error('Error fetching medical record:', error);
                        alert('Failed to load medical record data');
                    });
            }
        </script>

        <!-- Health Metrics Tab -->
        <div id="health-metrics" class="tab-content">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Blood Pressure Chart -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Blood Pressure History</h3>
                        <button type="button" data-modal-target="addBloodPressureModal"
                            class="px-3 py-1 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-plus mr-1"></i> Add Reading
                        </button>
                    </div>
                    <div class="h-64">
                        <canvas id="bloodPressureChart"></canvas>
                    </div>
                </div>

                <!-- Blood Sugar Chart -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Blood Sugar History</h3>
                        <button type="button" data-modal-target="addBloodSugarModal"
                            class="px-3 py-1 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-plus mr-1"></i> Add Reading
                        </button>
                    </div>
                    <div class="h-64">
                        <canvas id="bloodSugarChart"></canvas>
                    </div>
                </div>

                <!-- Heart Rate Chart -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Heart Rate History</h3>
                        <button type="button" data-modal-target="addHeartRateModal"
                            class="px-3 py-1 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-plus mr-1"></i> Add Reading
                        </button>
                    </div>
                    <div class="h-64">
                        <canvas id="heartRateChart"></canvas>
                    </div>
                </div>

            </div>

            <!-- Health Metrics Data Tables -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="px-4 py-3 bg-gray-50 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-700">Recent Health Metrics</h3>
                        <div class="flex space-x-2">
                            <button type="button"
                                class="px-3 py-1 bg-blue-100 text-blue-600 rounded text-xs hover:bg-blue-200">
                                <i class="fas fa-file-export mr-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Metric Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recorded By</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($healthMetrics as $metric)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($metric['date'])->format('M d, Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $metric['type'] === 'Blood Pressure' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $metric['type'] === 'Blood Sugar' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $metric['type'] === 'Heart Rate' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ $metric['type'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $metric['value'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $metric['recorded_by'] }}</div>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Diseases Tab -->
        <div id="diseases" class="tab-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Current Diagnoses</h3>
                <button type="button" data-modal-target="addDiseaseModal"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i> Add Disease
                </button>
            </div>

            @if (count($diseases) > 0)
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    @foreach ($diseases as $disease)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 flex justify-between items-center border-b">
                                <h4 class="text-lg font-medium text-gray-900">{{ $disease->name }}</h4>
                                <div
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $disease->category === 'chronic' ? 'red' : 'yellow' }}-100 text-{{ $disease->category === 'chronic' ? 'red' : 'yellow' }}-800">
                                    {{ ucfirst($disease->category) }}
                                </div>
                            </div>

                            <div class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $disease->description }}</p>

                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <h5 class="text-xs font-medium text-gray-500 mb-1">Diagnosed On</h5>
                                        <p class="text-sm font-medium">
                                            {{ \Carbon\Carbon::parse($disease->pivot->created_at)->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-medium text-gray-500 mb-1">Diagnosed By</h5>
                                        <p class="text-sm font-medium">Dr.
                                            {{ $disease->pivot->doctor->user->first_name ?? 'Unknown' }}
                                            {{ $disease->pivot->doctor->user->last_name ?? '' }}</p>
                                    </div>
                                </div>

                                @if ($disease->symptoms)
                                    <div class="mt-4">
                                        <h5 class="text-xs font-medium text-gray-500 mb-2">Common Symptoms</h5>
                                        <div class="flex flex-wrap">
                                            @foreach (explode(',', $disease->symptoms) as $symptom)
                                                <span
                                                    class="m-1 px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">{{ trim($symptom) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($disease->treatment)
                                    <div class="mt-4">
                                        <h5 class="text-xs font-medium text-gray-500 mb-1">Treatment</h5>
                                        <p class="text-sm text-gray-700">{{ $disease->treatment }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-2">
                                <button type="button"
                                    class="px-3 py-1 bg-blue-100 text-blue-600 text-xs rounded hover:bg-blue-200"
                                    onclick="editDisease({{ $disease->id }})">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button type="button"
                                    class="px-3 py-1 bg-red-100 text-red-600 text-xs rounded hover:bg-red-200"
                                    onclick="deleteDisease({{ $disease->id }})">
                                    <i class="fas fa-trash mr-1"></i> Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-disease fa-3x"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No diagnosed diseases</h3>
                    <p class="text-gray-500">This patient doesn't have any diagnosed diseases yet.</p>
                </div>
            @endif
        </div>

        <!-- Appointments Tab -->
        <div id="appointments" class="tab-content">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment History</h3>

            @if (count($appointments) > 0)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Doctor</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Notes</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($appointments as $appointment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 mr-2">
                                                    <i class="fas fa-user-md"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">Dr.
                                                        {{ $appointment->doctor->user->first_name ?? 'Unknown' }}
                                                        {{ $appointment->doctor->user->last_name ?? '' }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $appointment->doctor->speciality ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ ucfirst($appointment->type) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $appointment->status === 'canceled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                                {{ $appointment->notes ?? 'No notes available' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button type="button" class="text-indigo-600 hover:text-indigo-900 mr-3"
                                                onclick="viewAppointment({{ $appointment->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-3 bg-gray-50 flex justify-between items-center">
                        {{ $appointments->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-calendar-times fa-3x"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No appointment history</h3>
                    <p class="text-gray-500">This patient doesn't have any appointment history yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Medical Record Modal -->
    <div id="addMedicalRecordModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('doctor.medical.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="doctor_id" value="{{ auth()->user()->doctor->id }}">

                    <div class="bg-gray-50 px-4 py-3 border-b">
                        <h3 class="text-lg font-medium text-gray-900">Add Medical Record</h3>
                    </div>

                    <div class="px-4 py-3">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Record Title</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="dosage" class="block text-sm font-medium text-gray-700">Medication
                                    Dosage</label>
                                <input type="text" name="dosage" id="dosage"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                                <input type="text" name="frequency" id="frequency"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Add Record
                        </button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Disease Modal -->
    <div id="addDiseaseModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('doctor.diseases.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <div class="bg-gray-50 px-4 py-3 border-b">
                        <h3 class="text-lg font-medium text-gray-900">Add Disease</h3>
                    </div>

                    <div class="px-4 py-3">
                        <div class="mb-4">
                            <label for="disease_id" class="block text-sm font-medium text-gray-700">Disease</label>
                            <select name="disease_id" id="disease_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select a disease</option>
                                @foreach ($diseases as $disease)
                                    <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (if
                                applicable)</label>
                            <input type="text" name="duration" id="duration"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="e.g. 2 weeks, 3 months, chronic">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Add Disease
                        </button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Blood Pressure Modal -->
    <div id="addBloodPressureModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('doctor.blood-pressure.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="doctor_id" value="{{ auth()->user()->doctor->id }}">
                    
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-4 border-b">
                        <h3 class="text-lg font-medium text-white">Add Blood Pressure Reading</h3>
                    </div>

                    <div class="px-6 py-5 bg-gray-50">
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="systolic" class="block text-sm font-semibold text-gray-700 mb-1">Systolic (mmHg)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-heartbeat text-gray-400"></i>
                                    </div>
                                    <input type="number" name="systolic" id="systolic" required
                                        class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3"
                                        placeholder="120">
                                </div>
                            </div>

                            <div>
                                <label for="diastolic" class="block text-sm font-semibold text-gray-700 mb-1">Diastolic (mmHg)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-heartbeat text-gray-400"></i>
                                    </div>
                                    <input type="number" name="diastolic" id="diastolic" required
                                        class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3"
                                        placeholder="80">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="pulse" class="block text-sm font-semibold text-gray-700 mb-1">Pulse (bpm)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-heart text-gray-400"></i>
                                </div>
                                <input type="number" name="pulse" id="pulse"
                                    class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3"
                                    placeholder="75">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="bp_measured_at" class="block text-sm font-semibold text-gray-700 mb-1">Measurement Date & Time</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="datetime-local" name="measured_at" id="bp_measured_at" required
                                    class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-100 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-base font-medium text-white hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 ease-in-out">
                            <i class="fas fa-save mr-2"></i> Save Reading
                        </button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close transition-all duration-300 ease-in-out">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Blood Sugar Modal -->
    <div id="addBloodSugarModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('doctor.blood-sugar.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="doctor_id" value="{{ auth()->user()->doctor->id }}">
                    
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-4 py-4 border-b">
                        <h3 class="text-lg font-medium text-white">Add Blood Sugar Reading</h3>
                    </div>

                    <div class="px-6 py-5 bg-gray-50">
                        <div class="mb-6">
                            <label for="bs_value" class="block text-sm font-semibold text-gray-700 mb-1">Blood Sugar Level</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tint text-gray-400"></i>
                                </div>
                                <input type="number" name="value" id="bs_value" required step="0.01"
                                    class="pl-10 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3"
                                    placeholder="120.0">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="bs_unit" class="block text-sm font-semibold text-gray-700 mb-1">Unit</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-flask text-gray-400"></i>
                                </div>
                                <select name="unit" id="bs_unit" required
                                    class="pl-10 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 appearance-none">
                                    <option value="mg/dL">mg/dL</option>
                                    <option value="mmol/L">mmol/L</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="bs_measured_at" class="block text-sm font-semibold text-gray-700 mb-1">Measurement Time</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </div>
                                <input type="datetime-local" name="measured_at" id="bs_measured_at" required
                                    class="pl-10 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-100 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-base font-medium text-white hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 ease-in-out">
                            <i class="fas fa-save mr-2"></i> Save Reading
                        </button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close transition-all duration-300 ease-in-out">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Heart Rate Modal -->
    <div id="addHeartRateModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('doctor.hearth-rate.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="doctor_id" value="{{ auth()->user()->doctor->id }}">
                    
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-4 border-b">
                        <h3 class="text-lg font-medium text-white">Add Heart Rate Reading</h3>
                    </div>

                    <div class="px-6 py-5 bg-gray-50">
                        <div class="mb-6">
                            <label for="hr_value" class="block text-sm font-semibold text-gray-700 mb-1">Heart Rate</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-heartbeat text-gray-400"></i>
                                </div>
                                <input type="number" name="value" id="hr_value" required
                                    class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3"
                                    placeholder="72">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">bpm</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="hr_unit" class="block text-sm font-semibold text-gray-700 mb-1">Unit</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-ruler text-gray-400"></i>
                                </div>
                                <select name="unit" id="hr_unit" required
                                    class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 appearance-none">
                                    <option value="bpm">beats per minute (bpm)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hr_measured_at" class="block text-sm font-semibold text-gray-700 mb-1">Measurement Date & Time</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="datetime-local" name="measured_at" id="hr_measured_at" required
                                    class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-100 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-base font-medium text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 ease-in-out">
                            <i class="fas fa-save mr-2"></i> Save Reading
                        </button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close transition-all duration-300 ease-in-out">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Initialize charts with patient data
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked tab
                    button.classList.add('active');
                    document.getElementById(button.dataset.tab).classList.add('active');
                });
            });

            // Modal handling
            const modalButtons = document.querySelectorAll('[data-modal-target]');
            const modalCloseButtons = document.querySelectorAll('.modal-close');

            modalButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.getElementById(button.dataset.modalTarget);
                    modal.classList.remove('hidden');
                });
            });

            modalCloseButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = button.closest('[id$="Modal"]');
                    modal.classList.add('hidden');
                });
            });

            // Initialize Blood Pressure Chart
            const bpCtx = document.getElementById('bloodPressureChart').getContext('2d');
            const bpChart = new Chart(bpCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($bloodPressureChartData['labels']) !!},
                    datasets: [{
                            label: 'Systolic',
                            data: {!! json_encode($bloodPressureChartData['systolic']) !!},
                            borderColor: 'rgba(239, 68, 68, 1)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Diastolic',
                            data: {!! json_encode($bloodPressureChartData['diastolic']) !!},
                            borderColor: 'rgba(59, 130, 246, 1)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 40,
                            title: {
                                display: true,
                                text: 'mmHg'
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

            // Initialize Blood Sugar Chart
            const bsCtx = document.getElementById('bloodSugarChart').getContext('2d');
            const bsChart = new Chart(bsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($bloodSugarChartData['labels']) !!},
                    datasets: [{
                        label: 'Blood Sugar',
                        data: {!! json_encode($bloodSugarChartData['values']) !!},
                        borderColor: 'rgba(139, 92, 246, 1)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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

            // Initialize Heart Rate Chart
            const hrCtx = document.getElementById('heartRateChart').getContext('2d');
            const hrChart = new Chart(hrCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($heartRateChartData['labels']) !!},
                    datasets: [{
                        label: 'Heart Rate',
                        data: {!! json_encode($heartRateChartData['values']) !!},
                        borderColor: 'rgba(37, 99, 235, 1)',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4,
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'bpm'
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
        });

        // Functions to handle CRUD operations


        function deleteMedicalRecord(id) {
            if (confirm('Are you sure you want to delete this medical record?')) {
                // Implementation for deleting medical record
            }
        }

        function editDisease(id) {
            // Implementation for editing disease
            console.log('Edit disease', id);
        }

        function deleteDisease(id) {
            if (confirm('Are you sure you want to remove this disease from the patient?')) {
                // Implementation for deleting disease
            }
        }

        function editMetric(type, id) {
            // Implementation for editing health metric
            console.log('Edit metric', type, id);
        }

        function deleteMetric(type, id) {
            if (confirm(`Are you sure you want to delete this ${type} reading?`)) {
                // Implementation for deleting health metric
            }
        }
    </script>
@endsection
