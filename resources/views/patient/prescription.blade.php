@extends('layouts.patient')

@section('title', 'My Prescriptions')

@section('page-title', 'My Prescriptions')

@section('breadcrumb', 'Prescriptions')

@section('content')
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-card overflow-hidden">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-10 w-10 rounded-full bg-accent bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-prescription text-accent"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-xl font-bold text-gray-800">My Prescriptions</h1>
                        <p class="text-gray-600 text-sm">View all your medications and diagnosed conditions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
        <!-- Medications Section -->
        <div class="md:col-span-12 space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-card card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-pills text-accent mr-2"></i> My Medications
                    </h2>
                    <div class="text-sm">
                        <span class="text-gray-500">Last updated: {{ now()->format('M d, Y') }}</span>
                    </div>
                </div>

                @if ($medicals && $medicals->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg">
                            <thead class="bg-gray-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="py-3 px-4 text-left">Medication</th>
                                    <th class="py-3 px-4 text-left">Dosage</th>
                                    <th class="py-3 px-4 text-left">Frequency</th>
                                    <th class="py-3 px-4 text-left">Period</th>
                                    <th class="py-3 px-4 text-left">Doctor</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                                @foreach ($medicals as $medical)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="font-medium">{{ $medical->name }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($medical->description, 50) }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">{{ $medical->dosage }}</td>
                                        <td class="py-3 px-4">{{ $medical->frequency }}</td>
                                        <td class="py-3 px-4">
                                            <div class="text-xs">
                                                <span class="font-medium">Start:</span>
                                                {{ $medical->start_date->format('M d, Y') }}<br>
                                                <span class="font-medium">End:</span>
                                                {{ $medical->end_date ? $medical->end_date->format('M d, Y') : 'Ongoing' }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                                                    <i class="fas fa-user-md text-gray-500"></i>
                                                </div>
                                                <span>Dr.
                                                    {{ $medical->doctor->user->first_name . ' ' . $medical->doctor->user->last_name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button onclick="ShowMedCardDetiles({{ $medical->id }})"
                                                class="text-blue-500 hover:text-blue-700 mr-2" title="View Details">
                                                <i class="fas fa-eye mr-1"></i>
                                                <span>View</span>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 px-4 bg-gray-50 rounded-lg">
                        <div class="text-gray-500 mb-2">
                            <i class="fas fa-prescription-bottle-alt text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-1">No medications found</h3>
                        <p class="text-gray-500 text-sm">You don't have any prescribed medications at the moment.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Diagnosed Conditions Section -->
        <div class="md:col-span-12 space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-card card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-heartbeat text-accent mr-2"></i> My Diagnosed Conditions
                    </h2>
                    <div class="text-sm">
                        <span class="text-gray-500">Last updated: {{ now()->format('M d, Y') }}</span>
                    </div>
                </div>

                @if ($diseases && $diseases->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach ($diseases as $disease)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all">
                                <div class="flex items-start">
                                    <div
                                        class="h-10 w-10 rounded-full bg-{{ ['red', 'blue', 'green', 'purple', 'yellow', 'indigo'][array_rand(['red', 'blue', 'green', 'purple', 'yellow', 'indigo'])] }}-100 flex items-center justify-center mr-3">
                                        <i
                                            class="fas fa-virus text-{{ ['red', 'blue', 'green', 'purple', 'yellow', 'indigo'][array_rand(['red', 'blue', 'green', 'purple', 'yellow', 'indigo'])] }}-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800">{{ $disease->name }}</h3>
                                        <p class="text-xs text-gray-500 mb-2">{{ Str::limit($disease->description, 80) }}
                                        </p>

                                        <div class="flex flex-wrap gap-2 mb-2">
                                            <span class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded-full">
                                                {{ $disease->category }}
                                            </span>
                                            <span class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-full">
                                                Duration: {{ $disease->pivot->duration ?? 'Unspecified' }}
                                            </span>
                                        </div>

                                        <div class="text-xs text-gray-600">
                                            <span class="font-medium">Diagnosed by:</span>
                                            <span>Dr. {{ $disease->doctors->first()->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button onclick="ShowDisCardDetiles({{ $disease->id }})"
                                            class="text-accent hover:text-accentHover" title="View Details">
                                            <i class="fas fa-eye mr-1"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 px-4 bg-gray-50 rounded-lg">
                        <div class="text-gray-500 mb-2">
                            <i class="fas fa-clipboard-list text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-1">No conditions found</h3>
                        <p class="text-gray-500 text-sm">You don't have any diagnosed conditions at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Medication Details Modal -->
    <div id="medicationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-accent bg-opacity-20 flex items-center justify-center mr-3">
                            <i class="fas fa-pills text-accent"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800" id="medicationName">Medication Details</h3>
                    </div>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Treatment Period</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="far fa-calendar-plus text-green-500 mr-2"></i>
                                <span class="text-xs font-medium text-gray-500">Start Date:</span>
                                <span id="medicationStartDate" class="ml-2 text-sm text-gray-800"></span>
                            </div>
                            <div class="flex items-center">
                                <i class="far fa-calendar-minus text-red-500 mr-2"></i>
                                <span class="text-xs font-medium text-gray-500">End Date:</span>
                                <span id="medicationEndDate" class="ml-2 text-sm text-gray-800"></span>
                            </div>
                            <div class="flex items-center mt-1">
                                <div id="treatmentStatus" class="text-xs px-2 py-1 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Prescribed by</h4>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user-md text-blue-500"></i>
                            </div>
                            <div>
                                <span id="medicationDoctor" class="text-gray-800 font-medium"></span>
                                <div class="text-xs text-gray-500">Doctor ID: <span id="medicationDoctorId"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Treatment Details</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center mb-3">
                                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                                        <i class="fas fa-prescription-bottle text-purple-500"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Dosage</span>
                                        <div id="medicationDosage" class="text-sm text-gray-800 font-medium"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center mb-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                        <i class="fas fa-clock text-indigo-500"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Frequency</span>
                                        <div id="medicationFrequency" class="text-sm text-gray-800 font-medium"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Description</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p id="medicationDescription" class="text-gray-700"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-500">
                    <div>
                        <span class="font-medium">Created:</span>
                        <span id="medicationCreatedAt"></span>
                    </div>
                    <div>
                        <span class="font-medium">Last Updated:</span>
                        <span id="medicationUpdatedAt"></span>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="printMedication()" class="flex-1 py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center">
                        <i class="fas fa-print mr-2"></i> Print Details
                    </button>
                    <button onclick="closeModal()" class="flex-1 py-2 px-4 bg-accent text-white rounded-lg hover:bg-accentHover transition-colors flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disease Details Modal -->
    <div id="diseaseModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white p-4 border-b border-gray-200 z-10">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <i class="fas fa-virus text-accent mr-3"></i>
                        <h3 class="text-lg font-bold text-gray-800" id="diseaseName">Disease Details</h3>
                    </div>
                    <button onclick="closeDisModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-4">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500 mb-1">Category</div>
                        <span id="diseaseCategory" class="text-sm bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full"></span>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500 mb-1">Diagnosed by</div>
                        <div class="flex items-center">
                            <i class="fas fa-user-md text-blue-500 mr-2"></i>
                            <span id="diseaseDoctor" class="text-sm"></span>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs font-medium text-gray-500 mb-1">Description</div>
                        <p id="diseaseDescription" class="text-sm"></p>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs font-medium text-gray-500 mb-1">Symptoms</div>
                        <p id="diseaseSymptoms" class="text-sm"></p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-xs font-medium text-gray-500 mb-1">Prevention</div>
                            <p id="diseasePrevention" class="text-sm"></p>
                        </div>
                        
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-xs font-medium text-gray-500 mb-1">Treatment</div>
                            <p id="diseaseTreatment" class="text-sm"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="sticky bottom-0 bg-gray-50 p-4 border-t border-gray-200 flex gap-2">
                <button onclick="printDisease()" class="flex-1 py-2 px-3 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 flex items-center justify-center">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
                <button onclick="closeDisModal()" class="flex-1 py-2 px-3 bg-accent text-white text-sm rounded hover:bg-accentHover flex items-center justify-center">
                    <i class="fas fa-times mr-1"></i> Close
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('card-animate');
            });
        });

        function ShowMedCardDetiles(id) {
            fetch('/patient/medication/' + id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data) {
                        document.getElementById('medicationName').innerText = data.medical.name;
                        document.getElementById('medicationDosage').innerText = data.medical.dosage;
                        document.getElementById('medicationFrequency').innerText = data.medical.frequency;
                        document.getElementById('medicationDescription').innerText = data.medical.description;

                        const formatDate = (dateString) => {
                            if (!dateString) return 'Ongoing';
                            const date = new Date(dateString);
                            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        };

                        document.getElementById('medicationStartDate').innerText = formatDate(data.medical.start_date);
                        document.getElementById('medicationEndDate').innerText = data.medical.end_date ? formatDate(data.medical.end_date) : 'Ongoing';

                        document.getElementById('medicationDoctor').innerText = 'Dr. ' + (data.medical.doctor_name || 'Unknown');
                        document.getElementById('medicationDoctorId').innerText = data.medical.doctor_id;

                        document.getElementById('medicationCreatedAt').innerText = formatDate(data.medical.created_at);
                        document.getElementById('medicationUpdatedAt').innerText = formatDate(data.medical.updated_at);

                        const statusEl = document.getElementById('treatmentStatus');
                        if (data.medical.is_active) {
                            statusEl.innerText = 'Active';
                            statusEl.classList.add('bg-green-100', 'text-green-800');
                        } else {
                            statusEl.innerText = 'Completed';
                            statusEl.classList.add('bg-gray-100', 'text-gray-800');
                        }

                        document.getElementById('medicationModal').classList.remove('hidden');
                    } else {
                        alert('Failed to fetch medication details.');
                    }
                })
                .catch(error => console.error('Error fetching medication details:', error));
        }

        function ShowDisCardDetiles(id) {
            fetch('/patient/disease/' + id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.disease) {
                        // Populate the disease modal with data
                        document.getElementById('diseaseModal').querySelector('#diseaseName').innerText = data.disease.name;
                        document.getElementById('diseaseModal').querySelector('#diseaseCategory').innerText = data.disease.category;
                        document.getElementById('diseaseModal').querySelector('#diseaseDescription').innerText = data.disease.description;
                        document.getElementById('diseaseModal').querySelector('#diseaseSymptoms').innerText = data.disease.symptoms;
                        document.getElementById('diseaseModal').querySelector('#diseasePrevention').innerText = data.disease.prevention;
                        document.getElementById('diseaseModal').querySelector('#diseaseTreatment').innerText = data.disease.treatment;
                        
                        // Show the modal
                        document.getElementById('diseaseModal').classList.remove('hidden');
                    } else {
                        alert('Failed to fetch disease details.');
                    }
                })
                .catch(error => console.error('Error fetching disease details:', error));
        }
        function closeModal() {
            document.getElementById('medicationModal').classList.add('hidden');
        }
        function closeDisModal() {
            document.getElementById('diseaseModal').classList.add('hidden');
        }
        function printDisease(){
            const diseaseName = document.getElementById('diseaseName').innerText;
            const diseaseDescription = document.getElementById('diseaseDescription').innerText;
            const diseaseSymptoms = document.getElementById('diseaseSymptoms').innerText;
            const diseasePrevention = document.getElementById('diseasePrevention').innerText;
            const diseaseTreatment = document.getElementById('diseaseTreatment').innerText;

            const printContent = `
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
                    h1 { color: #2563eb; font-size: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 20px; }
                    .section { margin-bottom: 15px; background: #f9fafb; padding: 15px; border-radius: 8px; }
                    .section-title { font-weight: bold; color: #4b5563; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; }
                    .section-content { margin: 0; font-size: 15px; }
                    .footer { margin-top: 30px; font-size: 12px; color: #6b7280; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 15px; }
                </style>
                <h1>${diseaseName}</h1>
                
                <div class="section">
                    <div class="section-title">Description</div>
                    <p class="section-content">${diseaseDescription}</p>
                </div>
                
                <div class="section">
                    <div class="section-title">Symptoms</div>
                    <p class="section-content">${diseaseSymptoms}</p>
                </div>
                
                <div class="section">
                    <div class="section-title">Prevention</div>
                    <p class="section-content">${diseasePrevention}</p>
                </div>
                
                <div class="section">
                    <div class="section-title">Treatment</div>
                    <p class="section-content">${diseaseTreatment}</p>
                </div>
                
                <div class="footer">
                    Printed from HealthGate on ${new Date().toLocaleDateString()}
                </div>
            `;
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Print</title></head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        function printMedication(){
            const medicationName = document.getElementById('medicationName').innerText;
            const medicationDescription = document.getElementById('medicationDescription').innerText;
            const medicationDosage = document.getElementById('medicationDosage').innerText;
            const medicationFrequency = document.getElementById('medicationFrequency').innerText;
            const medicationStartDate = document.getElementById('medicationStartDate').innerText;
            const medicationEndDate = document.getElementById('medicationEndDate').innerText;

            const printContent = `
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
                    h1 { color: #2563eb; font-size: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 20px; }
                    .section { margin-bottom: 15px; background: #f9fafb; padding: 15px; border-radius: 8px; }
                    .section-title { font-weight: bold; color: #4b5563; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; }
                    .section-content { margin: 0; font-size: 15px; }
                    .footer { margin-top: 30px; font-size: 12px; color: #6b7280; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 15px; }
                </style>
                <h1>${medicationName}</h1>
                
                <div class="section">
                    <div class="section-title">Description</div>
                    <p class="section-content">${medicationDescription}</p>
                </div>
                
                <div class="section">
                    <div class="section-title">Dosage</div>
                    <p class="section-content">${medicationDosage}</p>
                </div>
                
                <div class="section">
                    <div class="section-title">Frequency</div>
                    <p class="section-content">${medicationFrequency}</p>
                </div>

                <div class="section">
                    <div class
                        "section-title">Treatment Period</div>
                    <p class="section-content">Start Date: ${medicationStartDate}</p>
                    <p class="section-content">End Date: ${medicationEndDate}</p>
                </div>
                <div class="footer">
                    Printed from HealthGate on ${new Date().toLocaleDateString()}
                </div>
            `;
            
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Medication Details</title></head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection
