async function showDiseaseDetails(diseaseId) {

    const modal = document.getElementById('diseaseDetailsModal');
    const modalContent = document.getElementById('diseaseDetailsContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('animate-fadeIn');
    
    modalContent.innerHTML = `
        <div class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-accent"></div>
        </div>
    `;

    document.getElementById('diseaseDetailsModal').classList.remove('hidden');


    fetch(`/doctor/diseases/${diseaseId}`)
        .then(response => response.json())
        .then(data => {
            if (data.disease) {
                
                
                const disease = data.disease;
                document.getElementById('modalDiseaseTitle').textContent = disease.name;



                let html = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <div class="rounded-lg overflow-hidden border border-gray-200 mb-4">
                                ${disease.image 
                                    ? `<img src="${disease.image}" alt="${disease.name}" class="w-full h-48 object-cover">`
                                    : `<div class="w-full h-48 bg-gray-100 flex items-center justify-center"><i class="fas fa-disease text-5xl text-gray-400"></i></div>`
                                }
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-sm uppercase text-gray-500 mb-2">Category</h4>
                                <p class="mb-4">
                                    <span class="px-3 py-1 bg-accent bg-opacity-10 text-accent rounded-full">
                                        ${disease.category.charAt(0).toUpperCase() + disease.category.slice(1)}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 space-y-5">
                            <div>
                                <h4 class="font-semibold text-sm uppercase text-gray-500 mb-2">Description</h4>
                                <p class="text-gray-800">${disease.description || 'No description available'}</p>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-sm uppercase text-gray-500 mb-2">Symptoms</h4>
                                <p class="text-gray-800">${disease.symptoms || 'No symptoms information available'}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                                <h4 class="font-semibold text-sm uppercase text-gray-500 mb-2">Treatment</h4>
                                                <p class="text-gray-800">${disease.treatment || 'No treatment information available'}</p>
                                </div>
                                
                                <div>
                                                <h4 class="font-semibold text-sm uppercase text-gray-500 mb-2">Prevention</h4>
                                                <p class="text-gray-800">${disease.prevention || 'No prevention information available'}</p>
                                        </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button onclick="prepareAssignment(${disease.id})" class="bg-accent hover:bg-accentHover text-white py-2 px-4 rounded-md transition-colors duration-300 flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Assign to Patient
                        </button>
                    </div>
                                                              `;

                document.getElementById('diseaseDetailsContent').innerHTML = html;
            } else {
                document.getElementById('diseaseDetailsContent').innerHTML =
                    '<p class="text-red-500">Failed to load disease details.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching disease details:', error);
            document.getElementById('diseaseDetailsContent').innerHTML =
                '<p class="text-red-500">An error occurred while loading disease details.</p>';
        });
}

function hideDiseaseModal() {
    document.getElementById('diseaseDetailsModal').classList.add('hidden');
}

function toggleAssignModal() {
    document.getElementById('assignDiseaseModal').classList.remove('hidden');
}

function hideAssignModal() {
    document.getElementById('assignDiseaseModal').classList.add('hidden');
}

function prepareAssignment(diseaseId) {
    document.getElementById('disease_id').value = diseaseId;

    hideDiseaseModal();
    toggleAssignModal();
}

window.addEventListener('click', function(event) {
    const diseaseModal = document.getElementById('diseaseDetailsModal');
    const assignModal = document.getElementById('assignDiseaseModal');

    if (event.target === diseaseModal) {
        hideDiseaseModal();
    }

    if (event.target === assignModal) {
        hideAssignModal();
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideDiseaseModal();
        hideAssignModal();
    }
});

window.showDiseaseDetails = showDiseaseDetails;
window.hideDiseaseModal = hideDiseaseModal;
window.toggleAssignModal = toggleAssignModal;
window.hideAssignModal = hideAssignModal;
window.prepareAssignment = prepareAssignment;