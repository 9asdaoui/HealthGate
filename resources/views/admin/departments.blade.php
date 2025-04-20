@extends('layouts.admin')

@section('title', 'Departments Management')

@section('page-title', 'Departments Management')

@section('breadcrumb', 'Departments')

@section('content')
    <div class="bg-secondary rounded-lg shadow-lg border border-borderColor p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-darkText">Departments List</h2>
            <button type="button" 
                class="bg-accent hover:bg-accentHover text-white px-4 py-2 rounded-lg flex items-center transition duration-300 ease-in-out"
                onclick="openAddModal()">
                <i class="fas fa-plus-circle mr-2"></i> Add Department
            </button>
        </div>

        <div class="overflow-x-auto bg-cardBg rounded-lg border border-borderColor">
            <table class="min-w-full divide-y divide-borderColor">
                <thead>
                    <tr class="bg-primary">
                        <th class="px-6 py-4 text-left text-xs font-medium text-lightText uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-lightText uppercase tracking-wider">Department Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-lightText uppercase tracking-wider">Number of Doctors</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-lightText uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borderColor">
                    @forelse($departments as $department)
                        <tr class="hover:bg-sidebarHover transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-darkText">#{{ $department->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-darkText">{{ $department->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-darkText">
                                <span class="bg-accent bg-opacity-20 text-accent px-3 py-1 rounded-full text-xs">
                                    {{ $department->doctors->count() }} doctors
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="openEditModal('{{ $department->id }}', '{{ $department->name }}')" 
                                        class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors duration-200" 
                                            onclick="return confirm('Are you sure you want to delete this department?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-lightText">No departments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>

    <!-- Add Department Modal -->
    <div id="addDepartmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-black opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-secondary rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-borderColor">
                <div class="bg-secondary px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-accent bg-opacity-20 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-hospital-alt text-accent"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-darkText">Add New Department</h3>
                            <div class="mt-2">
                                <form id="addDepartmentForm" action="{{ route('admin.departments.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-lightText mb-2">Department Name</label>
                                        <input type="text" name="name" id="name" required
                                            class="bg-primary border border-borderColor rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent block w-full shadow-sm text-darkText">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-primary px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-borderColor">
                    <button type="submit" form="addDepartmentForm"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-accent text-base font-medium text-white hover:bg-accentHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:ml-3 sm:w-auto sm:text-sm">
                        Add Department
                    </button>
                    <button type="button" onclick="closeAddModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-borderColor shadow-sm px-4 py-2 bg-cardBg text-base font-medium text-darkText hover:bg-sidebarHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Department Modal -->
    <div id="editDepartmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-black opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-secondary rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-borderColor">
                <div class="bg-secondary px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-accent bg-opacity-20 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-edit text-accent"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-darkText">Edit Department</h3>
                            <div class="mt-2">
                                <form id="editDepartmentForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="edit_name" class="block text-sm font-medium text-lightText mb-2">Department Name</label>
                                        <input type="text" name="name" id="edit_name" required
                                            class="bg-primary border border-borderColor rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent block w-full shadow-sm text-darkText">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-primary px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-borderColor">
                    <button type="submit" form="editDepartmentForm"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-accent text-base font-medium text-white hover:bg-accentHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:ml-3 sm:w-auto sm:text-sm">
                        Update Department
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-borderColor shadow-sm px-4 py-2 bg-cardBg text-base font-medium text-darkText hover:bg-sidebarHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openAddModal() {
            document.getElementById('addDepartmentModal').classList.remove('hidden');
            document.getElementById('name').focus();
        }

        function closeAddModal() {
            document.getElementById('addDepartmentModal').classList.add('hidden');
            document.getElementById('addDepartmentForm').reset();
        }

        function openEditModal(id, name) {
            document.getElementById('editDepartmentModal').classList.remove('hidden');
            document.getElementById('edit_name').value = name;
            document.getElementById('editDepartmentForm').action = `/admin/departments/${id}`;
            document.getElementById('edit_name').focus();
        }

        function closeEditModal() {
            document.getElementById('editDepartmentModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addDepartmentModal');
            const editModal = document.getElementById('editDepartmentModal');
            
            if (event.target === addModal) {
                closeAddModal();
            }
            
            if (event.target === editModal) {
                closeEditModal();
            }
        }

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAddModal();
                closeEditModal();
            }
        });
    </script>
@endsection