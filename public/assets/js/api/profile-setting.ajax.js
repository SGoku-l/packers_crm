function showToast(type, message) {
    const container = document.querySelector('.toast-container') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} fade mb-2`;
    toast.innerHTML = `
        <div class="toast-header">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="20" class="me-1">
            <h5 class="me-auto my-0">Mifty</h5>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">${message}</div>`;
    container.appendChild(toast);
    new bootstrap.Toast(toast, { delay: 4000, autohide: true }).show();
}

function createToastContainer() {
    const div = document.createElement('div');
    div.className = 'toast-container position-absolute top-0 end-0 p-3';
    document.body.appendChild(div);
    return div;
}

function previewModalImage(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = ev => document.getElementById('modalImagePreview').src = ev.target.result;
        reader.readAsDataURL(file);
    }
}

function previewSiteModalImage(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = ev => document.getElementById('modalSiteImagePreview').src = ev.target.result;
        reader.readAsDataURL(file);
    }
}

document.getElementById('saveProfileBtn').addEventListener('click', function () {
    const file = document.getElementById('modalFileInput').files[0];
    if (!file) return showToast('danger', 'Please select an image.');
    const formData = new FormData();
    formData.append('profileimage', file);
    fetch(window.profileRoutes.profilePic , { 
        method: 'POST', 
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}' },
             body: formData })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            document.getElementById('profilePreview').src = data.image_url;
            document.getElementById('modalImagePreview').src = data.image_url;
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
            showToast('success', data.message);
        } else showToast('danger', data.message);
    })
    .catch(err => showToast('danger', 'Upload failed.'));
});

document.getElementById('saveSiteImageBtn').addEventListener('click', function () {
    const file = document.getElementById('modalSiteFileInput').files[0];
    if (!file) return showToast('danger', 'Please select an image.');
    const formData = new FormData();
    formData.append('siteimage', file);
    fetch(window.profileRoutes.siteImage , {
         method: 'POST', 
         headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}' },
             body: formData })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            document.getElementById('siteImagePreview').src = data.site_url;
            document.getElementById('modalSiteImagePreview').src = data.site_url;
            bootstrap.Modal.getInstance(document.getElementById('editSiteImageModal')).hide();
            showToast('success', data.message);
        } else showToast('danger', data.message);
    })
    .catch(() => showToast('danger', 'Something went wrong while uploading.'));
});

// Change Password AJAX
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch(window.profileRoutes.changePassword, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            showToast('success', data.message);
            setTimeout(() => {
                window.location.href = data.redirect || "{{ route('login') }}";
            }, 2000);
        } else {
            showToast('danger', data.message);
        }
    })
    .catch(() => showToast('danger', 'Something went wrong!'));
});