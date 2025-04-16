@extends('layouts.admin')

@section('title', 'Disease Management')

@section('page-title', 'Disease Library')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-accent">Dashboard</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>Diseases</span>
@endsection

@section('styles')
<style>
    .disease-card {
        transition: all 0.3s ease;
        border-left: 4px solid theme('colors.accent');
    }
    
    .disease-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
    }
    
    .modal-container {
        z-index: 50;
    }
    
    .category-pill {
        transition: all 0.2s ease;
    }
    
    .category-pill:hover {
        transform: translateY(-2px);
    }
    
    .search-input:focus {
        box-shadow: 0 0 0 2px rgba(0, 169, 157, 0.3);
    }

    .modal-content-scrollable {
        max-height: 90vh;
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Header with actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-1">Disease Library</h1>
            <p class="text-lightText">Manage medical diseases and conditions</p>
        </div>
        
        <button onclick="openAddDiseaseModal()" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i> Add New Disease
        </button>
    </div>
    
    <!-- Filters and Search -->
    <div class="bg-secondary p-4 rounded-lg shadow mb-6 border border-borderColor">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <form action="{{ route('admin.diseases') }}" method="GET" class="flex items-center">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or description..." 
                            class="w-full px-4 py-2 pl-10 bg-primary border border-borderColor rounded-lg focus:outline-none search-input">
                        <span class="absolute left-3 top-2.5 text-lightText">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <button type="submit" class="ml-2 px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80">
                        Search
                    </button>
                </form>
            </div>
            
            <div class="flex-none flex items-center gap-2">
                <label class="text-sm whitespace-nowrap">Filter by:</label>
                <select name="category" onchange="window.location.href='{{ route('admin.diseases') }}?category='+this.value+'&search={{ request('search') }}'" 
                    class="px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                    <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                    @php
                        $categories = $allDiseases->pluck('category')->unique()->sort();
                    @endphp
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Category Pills -->
        <div class="flex flex-wrap gap-2 mt-4">
            <a href="{{ route('admin.diseases') }}" class="category-pill px-3 py-1 rounded-full text-xs {{ !request('category') || request('category') == 'all' ? 'bg-accent text-white' : 'bg-primary text-lightText border border-borderColor' }}">
                All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('admin.diseases', ['category' => $category, 'search' => request('search')]) }}" 
                    class="category-pill px-3 py-1 rounded-full text-xs {{ request('category') == $category ? 'bg-accent text-white' : 'bg-primary text-lightText border border-borderColor' }}">
                    {{ ucfirst($category) }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Diseases Table -->
    <div class="bg-secondary rounded-lg shadow-md overflow-hidden border border-borderColor mb-6">
        <div class="p-4 border-b border-borderColor flex justify-between items-center">
            <h2 class="text-xl font-bold">Diseases</h2>
            <span class="text-sm text-lightText">{{ $diseases->total() }} entries found</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-borderColor">
                <thead class="bg-primary">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-secondary divide-y divide-borderColor">
                    @forelse($diseases as $disease)
                        <tr class="hover:bg-primary transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($disease->image)
                                        <div class="h-10 w-10 rounded-full overflow-hidden mr-3">
                                            <img src="{{ $disease->image }}" alt="{{ $disease->name }}" class="h-full w-full object-cover">
                                        </div>
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-accent text-white flex items-center justify-center mr-3">
                                            <i class="fas fa-disease"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium">{{ $disease->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $disease->category == 'chronic' ? 'bg-red-900 text-red-200' : ($disease->category == 'infectious' ? 'bg-yellow-900 text-yellow-200' : 'bg-blue-900 text-blue-200') }}">
                                    {{ ucfirst($disease->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-lightText truncate max-w-xs">{{ $disease->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button onclick="viewDiseaseDetails({{ $disease->id }})" class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="openEditDiseaseModal({{ $disease->id }})" class="text-accent hover:text-accent-light">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="confirmDeleteDisease({{ $disease->id }})" class="text-red-400 hover:text-red-300">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-lightText">
                                <div class="flex flex-col items-center justify-center py-6">
                                    <i class="fas fa-disease text-3xl mb-2 text-lightText"></i>
                                    <p>No diseases found.</p>
                                    <button onclick="openAddDiseaseModal()" class="mt-4 px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition">
                                        <i class="fas fa-plus mr-2"></i> Add New Disease
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-borderColor">
            {{ $diseases->withQueryString()->links() }}
        </div>
    </div>
    
    <!-- Disease Category Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @php
            $categoryCount = $allDiseases->groupBy('category')->map->count();
            $totalDiseases = $allDiseases->count();
        @endphp
        
        <div class="stat-card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-lightText">Total Diseases</p>
                    <p class="text-2xl font-bold">{{ $totalDiseases }}</p>
                </div>
                <div class="h-12 w-12 rounded-full bg-accent bg-opacity-20 flex items-center justify-center">
                    <i class="fas fa-disease text-accent text-xl"></i>
                </div>
            </div>
        </div>
        
        @foreach($categoryCount as $category => $count)
            <div class="stat-card p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-lightText">{{ ucfirst($category) }}</p>
                        <p class="text-2xl font-bold">{{ $count }}</p>
                        <p class="text-xs text-lightText">{{ round(($count / $totalDiseases) * 100) }}% of all diseases</p>
                    </div>
                    <div class="h-12 w-12 rounded-full {{ $category == 'chronic' ? 'bg-red-900 bg-opacity-20' : ($category == 'infectious' ? 'bg-yellow-900 bg-opacity-20' : 'bg-blue-900 bg-opacity-20') }} flex items-center justify-center">
                        <i class="fas fa-virus {{ $category == 'chronic' ? 'text-red-400' : ($category == 'infectious' ? 'text-yellow-400' : 'text-blue-400') }} text-xl"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Add Disease Modal -->
<div id="addDiseaseModal" class="modal-overlay fixed inset-0 hidden z-50">
    <div class="modal-container fixed inset-0 flex items-center justify-center px-4">
        <div class="bg-secondary rounded-lg shadow-xl w-full max-w-3xl modal-content-scrollable">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center sticky top-0 z-10">
                <h3 class="text-xl font-bold">Add New Disease</h3>
                <button onclick="closeAddDiseaseModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.diseases.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Disease Name *</label>
                        <input type="text" id="name" name="name" required 
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium mb-1">Category *</label>
                        <select id="category" name="category" required
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                            <option value="">Select a category</option>
                            <option value="viral">Viral</option>
                            <option value="bacterial">Bacterial</option>
                            <option value="fungal">Fungal</option>
                            <option value="parasitic">Parasitic</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium mb-1">Description *</label>
                    <textarea id="description" name="description" rows="2" required
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                </div>

                <div class="mb-4">
                    <label for="symptoms" class="block text-sm font-medium mb-1">Symptoms *</label>
                    <textarea id="symptoms" name="symptoms" rows="2" required
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                    <p class="text-xs text-lightText mt-1">Enter symptoms separated by commas</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="prevention" class="block text-sm font-medium mb-1">Prevention</label>
                        <textarea id="prevention" name="prevention" rows="2"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                    </div>
                    <div>
                        <label for="treatment" class="block text-sm font-medium mb-1">Treatment</label>
                        <textarea id="treatment" name="treatment" rows="2"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium mb-1">Disease Image URL</label>
                    <input type="text" id="image" name="image" placeholder="https://example.com/image.jpg"
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                    <p class="text-xs text-lightText mt-1">Optional. Enter the URL of an image representing the disease</p>
                </div>

                <div class="text-right mt-4">
                    <button type="button" onclick="closeAddDiseaseModal()" class="px-4 py-2 border border-borderColor rounded-lg mr-2 hover:bg-primary transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                        Add Disease
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Disease Modal -->
<div id="editDiseaseModal" class="modal-overlay fixed inset-0 hidden z-50">
    <div class="modal-container fixed inset-0 flex items-center justify-center px-4">
        <div class="bg-secondary rounded-lg shadow-xl w-full max-w-3xl modal-content-scrollable">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center sticky top-0 z-10">
                <h3 class="text-xl font-bold">Edit Disease</h3>
                <button onclick="closeEditDiseaseModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editDiseaseForm" action="" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="edit_name" class="block text-sm font-medium mb-1">Disease Name *</label>
                        <input type="text" id="edit_name" name="name" required 
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                    </div>
                    <div>
                        <label for="edit_category" class="block text-sm font-medium mb-1">Category *</label>
                        <select id="edit_category" name="category" required
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                            <option value="">Select a category</option>
                            <option value="viral">Viral</option>
                            <option value="bacterial">Bacterial</option>
                            <option value="fungal">Fungal</option>
                            <option value="parasitic">Parasitic</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="edit_description" class="block text-sm font-medium mb-1">Description *</label>
                    <textarea id="edit_description" name="description" rows="2" required
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                </div>

                <div class="mb-4">
                    <label for="edit_symptoms" class="block text-sm font-medium mb-1">Symptoms *</label>
                    <textarea id="edit_symptoms" name="symptoms" rows="2" required
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="edit_prevention" class="block text-sm font-medium mb-1">Prevention</label>
                        <textarea id="edit_prevention" name="prevention" rows="2"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                    </div>
                    <div>
                        <label for="edit_treatment" class="block text-sm font-medium mb-1">Treatment</label>
                        <textarea id="edit_treatment" name="treatment" rows="2"
                            class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium mb-1">Disease Image URL</label>
                    <input type="text" id="image" name="image" placeholder="https://example.com/image.jpg"
                        class="w-full px-3 py-2 bg-primary border border-borderColor rounded-lg focus:outline-none focus:ring-2 focus:ring-accent">
                    <p class="text-xs text-lightText mt-1">Optional. Enter the URL of an image representing the disease</p>
                </div>

                <div class="text-right mt-4">
                    <button type="button" onclick="closeEditDiseaseModal()" class="px-4 py-2 border border-borderColor rounded-lg mr-2 hover:bg-primary transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                        Update Disease
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Disease Details Modal -->
<div id="viewDiseaseModal" class="modal-overlay fixed inset-0 hidden">
    <div class="modal-container fixed inset-0 flex items-center justify-center">
        <div class="bg-secondary rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center">
                <h3 class="text-xl font-bold" id="disease_title">Disease Details</h3>
                <button onclick="closeViewDiseaseModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/3">
                        <div id="disease_image_container" class="h-48 w-full rounded-lg overflow-hidden bg-primary flex items-center justify-center mb-4">
                            <img id="disease_image" src="" alt="" class="h-full w-full object-cover hidden">
                            <div id="disease_image_placeholder" class="text-6xl text-lightText">
                                <i class="fas fa-disease"></i>
                            </div>
                        </div>
                        
                        <div class="bg-primary p-4 rounded-lg mb-4">
                            <h4 class="font-semibold mb-2">Category</h4>
                            <p id="disease_category" class="text-sm px-3 py-1 rounded-full inline-block"></p>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3">
                        <h4 class="font-semibold mb-2">Description</h4>
                        <p id="disease_description" class="text-lightText mb-4"></p>
                        
                        <h4 class="font-semibold mb-2">Symptoms</h4>
                        <div id="disease_symptoms" class="flex flex-wrap gap-2 mb-4"></div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold mb-2">Prevention</h4>
                                <p id="disease_prevention" class="text-lightText"></p>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-2">Treatment</h4>
                                <p id="disease_treatment" class="text-lightText"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-right mt-6">
                    <button type="button" onclick="closeViewDiseaseModal()" class="px-4 py-2 border border-borderColor rounded-lg hover:bg-primary transition duration-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal-overlay fixed inset-0 hidden">
    <div class="modal-container fixed inset-0 flex items-center justify-center">
        <div class="bg-secondary rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="bg-primary p-4 border-b border-borderColor flex justify-between items-center">
                <h3 class="text-xl font-bold">Confirm Delete</h3>
                <button onclick="closeDeleteConfirmModal()" class="text-lightText hover:text-accent">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4 text-red-500">
                    <i class="fas fa-exclamation-triangle text-4xl mr-4"></i>
                    <p>Are you sure you want to delete this disease? This action cannot be undone.</p>
                </div>
                
                <p class="mb-4 text-sm text-lightText">Deleting this disease will remove all associated records including patient diagnoses.</p>
                
                <div class="text-right">
                    <button type="button" onclick="closeDeleteConfirmModal()" class="px-4 py-2 border border-borderColor rounded-lg mr-2 hover:bg-primary transition duration-200">
                        Cancel
                    </button>
                    <form id="deleteForm" action="" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-opacity-80 transition duration-200">
                            Delete Disease
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openAddDiseaseModal() {
        document.getElementById('addDiseaseModal').classList.remove('hidden');
    }
    
    function closeAddDiseaseModal() {
        document.getElementById('addDiseaseModal').classList.add('hidden');
    }
    
    function openEditDiseaseModal(diseaseId) {
        fetch(`/admin/diseases/${diseaseId}`)
            .then(response => response.json())
            .then(data => {
                const disease = data.disease;
                
                // Set form action
                document.getElementById('editDiseaseForm').action = `/admin/diseases/${diseaseId}`;
                
                // Populate form fields
                document.getElementById('edit_name').value = disease.name;
                document.getElementById('edit_category').value = disease.category;
                document.getElementById('edit_description').value = disease.description;
                document.getElementById('edit_symptoms').value = disease.symptoms;
                document.getElementById('edit_prevention').value = disease.prevention || '';
                document.getElementById('edit_treatment').value = disease.treatment || '';
                
                document.getElementById('editDiseaseModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching disease data:', error);
            });
    }
    
    function closeEditDiseaseModal() {
        document.getElementById('editDiseaseModal').classList.add('hidden');
    }
    
    function viewDiseaseDetails(diseaseId) {
        // Fetch disease data
        fetch(`/admin/diseases/${diseaseId}`)
            .then(response => response.json())
            .then(data => {
                const disease = data.disease;
                
                // Set disease title
                document.getElementById('disease_title').textContent = disease.name;
                
                // Set disease image if available
                const imageContainer = document.getElementById('disease_image_container');
                const image = document.getElementById('disease_image');
                const placeholder = document.getElementById('disease_image_placeholder');
                
                if (disease.image) {
                    image.src = disease.image;
                    image.alt = disease.name;
                    image.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                } else {
                    image.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
                
                // Set category with color
                const categoryElem = document.getElementById('disease_category');
                categoryElem.textContent = disease.category.charAt(0).toUpperCase() + disease.category.slice(1);
                
                // Set category color based on category
                if (disease.category === 'chronic') {
                    categoryElem.className = 'text-sm px-3 py-1 rounded-full inline-block bg-red-900 text-red-200';
                } else if (disease.category === 'infectious') {
                    categoryElem.className = 'text-sm px-3 py-1 rounded-full inline-block bg-yellow-900 text-yellow-200';
                } else {
                    categoryElem.className = 'text-sm px-3 py-1 rounded-full inline-block bg-blue-900 text-blue-200';
                }
                
                // Set description
                document.getElementById('disease_description').textContent = disease.description;
                
                // Set symptoms as pills
                const symptomsContainer = document.getElementById('disease_symptoms');
                symptomsContainer.innerHTML = '';
                
                const symptoms = disease.symptoms.split(',').map(s => s.trim());
                symptoms.forEach(symptom => {
                    if (symptom) {
                        const pill = document.createElement('span');
                        pill.className = 'px-3 py-1 bg-primary text-lightText rounded-full text-xs';
                        pill.textContent = symptom;
                        symptomsContainer.appendChild(pill);
                    }
                });
                
                // Set prevention and treatment
                document.getElementById('disease_prevention').textContent = disease.prevention || 'No prevention information available';
                document.getElementById('disease_treatment').textContent = disease.treatment || 'No treatment information available';
                
                // Show the modal
                document.getElementById('viewDiseaseModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching disease data:', error);
            });
    }
    
    function closeViewDiseaseModal() {
        document.getElementById('viewDiseaseModal').classList.add('hidden');
    }
    
    // Delete Confirmation Modal Functions
    function confirmDeleteDisease(diseaseId) {
        document.getElementById('deleteForm').action = `/admin/diseases/${diseaseId}`;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
    
    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    }
    
    // Close modals when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
</script>
@endsection