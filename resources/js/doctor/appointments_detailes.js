document.addEventListener('DOMContentLoaded', function () {
    // Set default dates for prescription form
    const today = new Date();
    const nextMonth = new Date();
    nextMonth.setMonth(today.getMonth() + 1);

    if (document.getElementById('start_date')) {
        document.getElementById('start_date').valueAsDate = today;
    }

    if (document.getElementById('end_date')) {
        document.getElementById('end_date').valueAsDate = nextMonth;
    }
});

function openAddPrescriptionModal() {
    console.log('Opening modal...');
    const modal = document.getElementById('prescriptionModal');
    console.log('Modal element:', modal);
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePrescriptionModal() {
    document.getElementById('prescriptionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openAddMedicalRecordModal() {
    document.getElementById('medicalRecordModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMedicalRecordModal() {
    document.getElementById('medicalRecordModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

window.openAddPrescriptionModal = openAddPrescriptionModal;
window.closePrescriptionModal = closePrescriptionModal;
window.openAddMedicalRecordModal = openAddMedicalRecordModal;
window.closeMedicalRecordModal = closeMedicalRecordModal;