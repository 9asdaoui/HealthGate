@extends('layouts.doctor')

@section('title', 'Disease Library')

@section('page-title', 'Diseases Library')

@section('breadcrumb', 'Diseases Library')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Disease Library</h2>
        <p class="text-gray-600">Browse and manage common diseases for your medical practice</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-card p-5 mb-6">
                <h3 class="text-lg font-semibold mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('doctor.diseases', ['category' => 'all']) }}"
                            class="block py-2 px-4 rounded-md {{ request()->query('category') == 'all' || !request()->query('category') ? 'bg-accent text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            All Diseases
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.diseases', ['category' => 'viral']) }}"
                            class="block py-2 px-4 rounded-md {{ request()->query('category') == 'viral' ? 'bg-accent text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            <i class="fas fa-virus mr-2"></i> Viral Diseases
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.diseases', ['category' => 'bacterial']) }}"
                            class="block py-2 px-4 rounded-md {{ request()->query('category') == 'bacterial' ? 'bg-accent text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            <i class="fas fa-bacterium mr-2"></i> Bacterial Diseases
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.diseases', ['category' => 'fungal']) }}"
                            class="block py-2 px-4 rounded-md {{ request()->query('category') == 'fungal' ? 'bg-accent text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            <i class="fas fa-seedling mr-2"></i> Fungal Diseases
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.diseases', ['category' => 'parasitic']) }}"
                            class="block py-2 px-4 rounded-md {{ request()->query('category') == 'parasitic' ? 'bg-accent text-white' : 'bg-gray-100 hover:bg-gray-200' }}">
                            <i class="fas fa-bug mr-2"></i> Parasitic Diseases
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Search Panel -->
            <div class="bg-white rounded-lg shadow-card p-5">
                <h3 class="text-lg font-semibold mb-4">Search Diseases</h3>
                <form action="{{ route('doctor.diseases') }}" method="GET">
                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Disease Name</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request()->query('search') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50 pl-10"
                                placeholder="Search diseases...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-accent hover:bg-accentHover text-white py-2 px-4 rounded-md transition-colors duration-300">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-card p-5">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">
                        {{ request()->query('category') ? ucfirst(request()->query('category')) . ' Diseases' : 'All Diseases' }}
                    </h3>

                    <button type="button" onclick="toggleAssignModal()"
                        class="bg-accent hover:bg-accentHover text-white py-2 px-4 rounded-md transition-colors duration-300 flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i> Assign to Patient
                    </button>
                </div>

                <!-- Disease Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($diseases as $disease)
                        <div
                            class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="relative h-40 bg-gray-200">
                                @if ($disease->image)
                                    <img src="{{ $disease->image }}" alt="{{ $disease->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <i class="fas fa-disease text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-accent text-white text-xs px-2 py-1 rounded-full">
                                    {{ ucfirst($disease->category) }}
                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="font-semibold text-lg mb-2">{{ $disease->name }}</h4>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $disease->description }}</p>

                                <button type="button" onclick="showDiseaseDetails({{ $disease->id }})"
                                    class="text-accent hover:text-accentHover text-sm font-semibold">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-8 text-center">
                            <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No diseases found. Try adjusting your search criteria.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $diseases->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Disease Details Modal -->
    <div id="diseaseDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800" id="modalDiseaseTitle">Disease Details</h3>
                    <button type="button" onclick="hideDiseaseModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="diseaseDetailsContent" class="space-y-6">
                    <!-- Content will be loaded here via JavaScript -->
                    <div class="flex justify-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-accent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Disease Modal -->
    <div id="assignDiseaseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-semibold text-gray-800">Assign Disease to Patient</h3>
                    <button type="button" onclick="hideAssignModal()"
                        class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('doctor.diseases.assign') }}" method="POST">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Select
                                Patient</label>
                            <div class="relative">
                                <select id="patient_id" name="patient_id" required
                                    class="w-full rounded-md border-gray-300 pl-4 pr-10 py-2.5 text-gray-700 bg-white shadow-sm hover:border-accent focus:border-accent focus:ring-2 focus:ring-accent focus:ring-opacity-30 transition-colors appearance-none">
                                    <option value="">-- Select a patient --</option>
                                    @foreach ($patients ?? [] as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->user->first_name }}
                                            {{ $patient->user->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="disease_id" class="block text-sm font-medium text-gray-700 mb-2">Select
                                Disease</label>
                            <div class="relative">
                                <select id="disease_id" name="disease_id" required
                                    class="w-full rounded-md border-gray-300 pl-4 pr-10 py-2.5 text-gray-700 bg-white shadow-sm hover:border-accent focus:border-accent focus:ring-2 focus:ring-accent focus:ring-opacity-30 transition-colors appearance-none">
                                    <option value="">-- Select a disease --</option>
                                    @foreach ($allDiseases ?? [] as $disease)
                                        <option value="{{ $disease->id }}">{{ $disease->name }}
                                            ({{ ucfirst($disease->category) }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Disease Duration
                                (optional)</label>
                            <div class="relative">
                                <input type="text" id="duration" name="duration"
                                    placeholder="e.g., 2 weeks, 3 months, etc."
                                    class="w-full rounded-md border-gray-300 pl-10 py-2.5 text-gray-700 bg-white shadow-sm hover:border-accent focus:border-accent focus:ring-2 focus:ring-accent focus:ring-opacity-30 transition-colors">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" onclick="hideAssignModal()"
                            class="px-5 py-2.5 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-accent hover:bg-accentHover text-white rounded-md transition-colors duration-300 font-medium">
                            <i class="fas fa-check-circle mr-2"></i> Assign Disease
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@vite('resources/js/doctor/disease.js')
@endpush
