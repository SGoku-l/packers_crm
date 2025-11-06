@include('admin.header')
@include('admin.rightsidebar')
@include('admin.leftsidebar')
@include('partials.toasts')

<div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title & Breadcrumb -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-flex justify-content-between align-items-center">
                        <h4 class="page-title mb-0">Admin Management</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Mifty</a></li>
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Admin Management</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">

                        <!-- Card Header -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Export Table</h4>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModalScrollable">
                                ADD ADMIN
                            </button>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped" id="datatable_1">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Admin Access Role</th>
                                            <th>Login Time</th>
                                            <th>Logout Time</th>
                                            <th>Modified By</th>
                                            <th>Modified Date/Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle" id="departmentTableBody">
                                        <tr>
                                            
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Export Buttons -->
                                <div class="d-flex gap-2 mt-3">
                                    <button type="button" class="btn btn-sm btn-primary csv">Export CSV</button>
                                    <button type="button" class="btn btn-sm btn-primary sql">Export SQL</button>
                                    <button type="button" class="btn btn-sm btn-primary txt">Export TXT</button>
                                    <button type="button" class="btn btn-sm btn-primary json">Export JSON</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Department Modal -->
        <div class="modal fade" id="exampleModalScrollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="exampleModalScrollableTitle">Add Admin</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="adminForm">
                            @csrf
                            <div class="mb-3">
                                <label for="adminName" class="form-label">Name</label>
                                <input type="text" class="form-control mb-2" id="adminName"
                                    placeholder="Enter Name" name="adminName">

                                <label for="adminEmail" class="form-label">Email</label>
                                <input type="email" class="form-control mb-3" id="adminEmail"
                                    placeholder="Enter Email" name="adminEmail">

                                <label for="adminPhone" class="form-label">Phone Number</label>
                                <input type="number" class="form-control mb-3" id="adminPhone"
                                    placeholder="Enter Phone Number" name="adminPhone">

                                <label for="adminPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Enter Password">
                                    <span class="input-group-text toggle-password" onclick="togglePassword('adminPassword', this)">🙈</span>
                                </div>  

                                <label for="adminconformPassword" class="form-label">Confrom Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="adminconformPassword" name="adminconformPassword" placeholder="Enter The Password Again">
                                    <span class="input-group-text toggle-password" onclick="togglePassword('adminconformPassword', this)">🙈</span>
                                </div>   

                                <label for="adminRole" class="form-label">Access Role</label> 
                                <select name="adminRole" id="createAdminRole" class="form-control mb-3" placeholder="Select Department Remark">

                                </select>      
                                    
                            </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!-- Update Department -->
         <div class="modal fade" id="updateDepartmentForm" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="exampleModalScrollableTitle">Update Admin</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="updateAdminForm">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" id="updateAdminId" name="id">  
                                <label for="adminName" class="form-label">Name</label>
                                <input type="text" class="form-control mb-2" id="adminName"
                                    placeholder="Enter Name" name="adminName">

                                <label for="adminEmail" class="form-label">Email</label>
                                <input type="email" class="form-control mb-3" id="adminEmail"
                                    placeholder="Enter Email" name="adminEmail">

                                <label for="adminPhone" class="form-label">Phone Number</label>
                                <input type="number" class="form-control mb-3" id="adminPhone"
                                    placeholder="Enter Phone Number" name="adminPhone">

                                <label for="adminPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="adminPassword" name="adminPassword">
                                    <span class="input-group-text toggle-password" onclick="togglePassword('adminPassword', this)">🙈</span>
                                </div>  

                                <label for="adminconformPasswor" class="form-label">Conform Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="adminconformPassword" name="adminconformPassword">
                                    <span class="input-group-text toggle-password" onclick="togglePassword('adminconformPassword', this)">🙈</span>
                                </div>   

                                <label for="updateAdminRole" class="form-label">Access Role</label> 
                                <select name="adminRole" id="updateAdminRole" class="form-control mb-3" placeholder="Select Department Remark">

                                </select>      
                                    
                            </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- End Modal -->

        <!-- SCRIPT -->
        <script>
            function togglePassword(inputId, icon) {
                const input = document.getElementById(inputId);
                if (input.type === "password") {
                    input.type = "text";
                    icon.textContent = "👁️";
                } else {
                    input.type = "password";
                    icon.textContent = "🙈";
                }
            }

            /* -----------------------------
              Bootstrap Toast Helper
            ------------------------------ */
            function showToast(type, message) {
                const container = document.querySelector('.toast-container') || createToastContainer();
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-bg-${type} fade mb-2`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.innerHTML = `
                    <div class="toast-header">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="20" class="me-1">
                        <h5 class="me-auto my-0">Mifty</h5>
                        <small>Just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                `;
                container.appendChild(toast);
                const bootstrapToast = new bootstrap.Toast(toast, { delay: 4000, autohide: true });
                bootstrapToast.show();
            }

            function createToastContainer() {
                const div = document.createElement('div');
                div.className = 'toast-container position-absolute top-0 end-0 p-3';
                document.body.appendChild(div);
                return div;
            }

            let canEdit = false;
            let canDelete = false;
            let canCreate = false;
            let canView = false;

            // reusable row builder function
            function buildRow(add) {
                let actions = "";

                if (canEdit) {
                    actions += `
                        <a href="#" class="edit-btn" data-id="${add.id}" data-bs-toggle="modal" data-bs-target="#updateDepartmentForm">
                            <i class="las la-pen text-secondary font-16"></i>
                        </a>
                    `;
                }

                if (canDelete) {
                    actions += `
                        <a href="#" class="delete-btn" data-id="${add.id}">
                            <i class="las la-trash-alt text-secondary font-16"></i>
                        </a>
                    `;
                }

                return `
                    <tr id="row-${add.id}">
                        <td>${add.name}</td>
                        <td>${add.email}</td>
                        <td>${add.phone}</td>
                        <td>${add.role ? add.role.department_name : '-'}</td>
                        <td>${add.login_time ?? '-'}</td>
                        <td>${add.logout_time ?? '-'}</td>
                        <td>${add.modified_by_user ? add.modified_by_user.name : '-'}</td>
                        <td>${add.modified_at ? new Date(add.modified_at).toLocaleString() : '-'}</td>
                        <td class="text-end">${actions}</td>
                    </tr>
                `;
            }

            // Handle update admin form
            document.getElementById("updateAdminForm").addEventListener("submit", function(e) {
                e.preventDefault();
                let id = document.getElementById("updateAdminId").value;
                let formData = new FormData(this);

                axios.post(`adminup/${id}`, formData, {
                    headers: { 
                        "X-HTTP-Method-Override": "PUT" 
                    }
                })
                .then(res => {
                    const addm = res.data.admin;

                    // Replace row with updated data
                    document.querySelector(`#row-${id}`).outerHTML = buildRow(addm);

                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById("updateDepartmentForm")).hide();

                    showToast('success', 'Admin updated successfully.');
                })
                .catch(err => {
                    console.error(err);
                    showToast('danger', 'Error updating admin.');
                });
            });

            // Handle delete button click
            document.addEventListener("click", function(e) {
                if (e.target.closest(".delete-btn")) {
                    e.preventDefault();
                    let id = e.target.closest(".delete-btn").dataset.id;

                    if (!confirm("Are you sure you want to delete this department?")) return;

                    axios.delete(`admindes/${id}`)
                        .then(() => {
                            document.getElementById(`row-${id}`).remove();
                            showToast('success', 'Admin deleted successfully.');
                        })
                        .catch(err => {
                            console.error(err);
                            showToast('danger', 'Error deleting admin.');
                        });
                }
            });

            // Handle edit button click
            document.addEventListener("click", function(e) {
                if (e.target.closest(".edit-btn")) {
                    e.preventDefault(); 
                    let id = e.target.closest(".edit-btn").dataset.id;

                    axios.get(`admin/${id}`)
                        .then(res => {
                            let admin = res.data.admin;
                            document.getElementById("updateAdminForm").reset();
                            document.getElementById("updateAdminId").value = admin.id;
                            document.querySelector("#updateAdminForm [name='adminName']").value = admin.name;
                            document.querySelector("#updateAdminForm [name='adminEmail']").value = admin.email;
                            document.querySelector("#updateAdminForm [name='adminPhone']").value = admin.phone;

                            const departments = res.data.role;
                            let html = "";

                            departments.forEach(depart => {
                                html += `
                                    <option value="${depart.id}" ${depart.id == admin.role_id ? 'selected' : ''}>
                                        ${depart.department_name}
                                    </option>
                                `;
                            });

                            document.getElementById("updateAdminRole").innerHTML = html;
                            showToast('info', 'Admin details loaded for editing.');
                        })
                        .catch(err => {
                            document.getElementById("updateAdminRole").innerHTML =
                                `<p class="text-danger">Error loading Roles</p>`;
                            console.error(err);
                            showToast('danger', 'Error loading admin data.');
                        });
                }
            });

            // Handle add admin form
            document.getElementById("adminForm").addEventListener("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                axios.post("{{ route('new.admin') }}", formData)
                    .then(response => {
                        // Handle Laravel JSON properly
                        if (response.data && response.data.status === true) {
                            const add = response.data.admin;

                            document.querySelector("#departmentTableBody").insertAdjacentHTML("beforeend", buildRow(add));

                            const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalScrollable'));
                            modal.hide();

                            document.getElementById("adminForm").reset();

                            showToast('success', response.data.message || 'Admin added successfully.');
                        } else {
                            console.warn('Unexpected API response:', response);
                            showToast('warning', 'Admin may have been saved, but response was unexpected.');
                        }
                    })
                    .catch(error => {
                        console.error('Admin Save Error:', error);

                        if (error.response && error.response.data && error.response.data.message) {
                            showToast('danger', error.response.data.message);
                        } else {
                            showToast('danger', 'Something went wrong while saving admin.');
                        }
                    });
            });

            // Load all admin data
            axios.get("{{ route('admin.alldata') }}")
                .then(response => {
                    const admin = response.data.admin;
                    const department = response.data.department;

                    canEdit = response.data.permissions.edit;
                    canDelete = response.data.permissions.delete;
                    canCreate = response.data.permissions.create;
                    canView = response.data.permissions.view;

                    let rows = "";
                    admin.forEach(add => {
                        rows += buildRow(add);
                    });
                    document.getElementById("departmentTableBody").innerHTML = rows;

                    let html = "";
                    department.forEach(depart => {
                        html += `<option value="${depart.id}">${depart.department_name}</option>`;
                    });
                    document.getElementById("createAdminRole").innerHTML = html;

                    const addBtn = document.querySelector('[data-bs-target="#exampleModalScrollable"]');
                    if (!canCreate && addBtn) addBtn.style.display = 'none';

                    showToast('success', 'Admin data loaded successfully.');
                }).catch(error => {
                    document.getElementById("departmentTableBody").innerHTML =
                        `<tr><td colspan="9" class="text-danger text-center">Error loading Admin</td></tr>`;
                    document.getElementById("createAdminRole").innerHTML =
                        `<p class="text-danger">Error loading menus</p>`;
                    console.error(error);
                    showToast('danger', 'Error loading admin data.');
                });
        </script>

@include('admin.footer')