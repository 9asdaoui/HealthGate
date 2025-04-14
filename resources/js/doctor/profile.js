document.addEventListener('DOMContentLoaded', function () {
    const imageUpload = document.getElementById('image-upload');
    const profileImage = document.getElementById('profile-image');
    const modalImageUpload = document.getElementById('modal-image-upload');
    const modalProfileImage = document.getElementById('modal-profile-image');

    if (imageUpload && profileImage) {
        imageUpload.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const src = URL.createObjectURL(e.target.files[0]);
                profileImage.src = src;
                if (modalProfileImage) modalProfileImage.src = src;
            }
        });
    }

    if (modalImageUpload && modalProfileImage) {
        modalImageUpload.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const src = URL.createObjectURL(e.target.files[0]);
                modalProfileImage.src = src;
                if (profileImage) profileImage.src = src;
            }
        });
    }

    const editProfileBtn = document.getElementById('edit-profile-btn');
    const editProfessionalInfoBtn = document.getElementById('edit-professional-info-btn');
    const editProfileModal = document.getElementById('edit-profile-modal');
    const closeModalBtn = document.getElementById('close-modal');

    if (editProfileBtn && editProfileModal) {
        editProfileBtn.addEventListener('click', function () {
            editProfileModal.classList.remove('hidden');
        });
    }

    if (editProfessionalInfoBtn && editProfileModal) {
        editProfessionalInfoBtn.addEventListener('click', function () {
            editProfileModal.classList.remove('hidden');
        });
    }

    if (closeModalBtn && editProfileModal) {
        closeModalBtn.addEventListener('click', function () {
            editProfileModal.classList.add('hidden');
        });
    }

    window.addEventListener('click', function (e) {
        if (editProfileModal && e.target === editProfileModal) {
            editProfileModal.classList.add('hidden');
        }
    });
});

