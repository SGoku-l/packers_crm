@include('admin.header')
@include('admin.rightsidebar')
@include('admin.leftsidebar')
@include('partials.toasts')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Profile</h4>
                        <div>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Mifty</a></li>
                                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- LEFT PROFILE CARD -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body p-4 rounded text-center img-bg"></div>
                        <div class="position-relative">
                            <div class="shape overflow-hidden text-card-bg">
                                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="card-body mt-n6">
                            <div class="text-center">
                                <div class="position-relative profile-image-wrapper mb-3">
                                    <img id="profilePreview"
                                        src="{{ Auth::user()->profileImage ? asset('uploads/profile/' . Auth::user()->profileImage->profile_pic) : asset('assets/images/users/avatar-5.jpg') }}"
                                        alt="Profile Picture"
                                        class="rounded-circle img-fluid profile-img">

                                    <div class="edit-icon" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                        <i class="las la-edit"></i>
                                    </div>
                                </div>
                                <h5 class="m-0 fs-3 fw-bold">{{ ucfirst(Auth::user()->name) }}</h5>
                                <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                                <p class="text-body mb-0"><i class="iconoir-phone fs-20 me-1 text-muted"></i>+91 {{ Auth::user()->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SETTINGS RIGHT -->
                <div class="col-lg-8">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fw-medium active" data-bs-toggle="tab" href="#settings" role="tab">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" data-bs-toggle="tab" href="#changePassword" role="tab">Change Password</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- SETTINGS -->
                        <div class="tab-pane p-3 fade show active" id="settings" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Personal Information</h4>
                                </div>
                                <div class="card-body pt-0">
                                    <form id="profileForm">
                                        @csrf
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3 col-12">
                                                <label class="form-label mb-md-0">First Name</label>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <input class="form-control" type="text" value="{{ Auth::user()->name }}" name="name" id="name">
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3 col-12">
                                                <label class="form-label mb-md-0">Contact Phone</label>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-phone"></i></span>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->phone }}" name="phone" id="phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3 col-12">
                                                <label class="form-label mb-md-0">Email</label>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-at"></i></span>
                                                    <input type="text" class="form-control" value="{{ Auth::user()->email }}" name="email" id="email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-9 offset-md-3">
                                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                                <button type="button" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- CHANGE PASSWORD -->
                        <div class="tab-pane p-3 fade" id="changePassword" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Change Password</h4>
                                </div>
                                <div class="card-body pt-0">
                                    <form>
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3 col-12">
                                                <label class="form-label mb-md-0">Current Password</label>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <input class="form-control" type="password" placeholder="Current Password">
                                                <a href="#" class="text-primary font-12">Forgot password?</a>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3 col-12">
                                                <label class="form-label mb-md-0">New Password</label>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <input class="form-control" type="password" placeholder="New Password">
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3 col-12">
                                                <label class="form-label mb-md-0">Confirm Password</label>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <input class="form-control" type="password" placeholder="Re-enter Password">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-9 offset-md-3">
                                                <button type="submit" class="btn btn-primary me-2">Change Password</button>
                                                <button type="button" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer text-center text-sm-start d-print-none">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0 rounded-bottom-0">
                            <div class="card-body text-center text-md-start">
                                <p class="text-muted mb-0">
                                    © <script>document.write(new Date().getFullYear())</script> Mifty
                                    <span class="text-muted d-block d-md-inline-block float-md-end">
                                        Design with <i class="iconoir-heart-solid text-danger align-middle"></i> by 123Krishnagiri
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImagePreview"
                    src="{{ Auth::user()->profileImage ? asset('uploads/profile/' . Auth::user()->profileImage->profile_pic) : asset('assets/images/users/avatar-5.jpg') }}"
                    class="rounded-circle mb-3" style="width: 130px; height: 130px; object-fit: cover; border: 3px solid #dee2e6;">

                <input type="file" id="modalFileInput" accept="image/*" name="profileimage" class="form-control mb-3" onchange="previewModalImage(event)">
                <button class="btn btn-primary" id="saveProfileBtn">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
function previewModalImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('modalImagePreview').src = e.target.result;
        reader.readAsDataURL(file);
    }
}

document.getElementById('saveProfileBtn').addEventListener('click', function () {
    const file = document.getElementById('modalFileInput').files[0];
    if (!file) return console.warn("No file selected.");

    const formData = new FormData();
    formData.append('profileimage', file);

    fetch("{{ route('profile.pic') }}", {
        method: "POST",
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log("📡 API Response:", data); // Visible in DevTools Console
        if (data.status) {
            document.getElementById('profilePreview').src = data.image_url;
            document.getElementById('modalImagePreview').src = data.image_url;
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
        } else {
            console.error("Upload failed:", data.message);
        }
    })
    .catch(err => console.error("Error uploading:", err));
});

document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('profile.updateInfo') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log("✅ API Response:", data); // <--- 👈 shows JSON in DevTools console

        if (data.status) {
            // ✅ Update displayed info without reload
            document.querySelector('.fs-3.fw-bold').textContent = formData.get('name');
            document.querySelector('.text-muted.mb-2').textContent = formData.get('email');
            document.querySelector('.text-body.mb-0').innerHTML = 
                `<i class="iconoir-phone fs-20 me-1 text-muted"></i>+91 ${formData.get('phone')}`;

            toastr.success(data.message);
        } else {
            toastr.error(data.message || "Failed to update profile");
        }
    })
    .catch(err => {
        console.error("❌ Fetch Error:", err);
        toastr.error("Something went wrong!");
    });
});
</script>

<style>
.profile-image-wrapper {
    position: relative;
    display: inline-block;
}
.profile-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 3px solid #fff;
}
.edit-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: #0d6efd;
    color: #fff;
    border-radius: 50%;
    width: 34px;
    height: 34px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border: 2px solid #fff;
    transition: all 0.2s ease;
}
.edit-icon:hover {
    background-color: #0b5ed7;
    transform: scale(1.05);
}
@media (max-width: 767px) {
    label.form-label {
        text-align: left !important;
        display: block;
        margin-bottom: 0.4rem;
    }
}
</style>