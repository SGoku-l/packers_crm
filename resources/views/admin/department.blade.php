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
                        <h4 class="page-title mb-0">Department</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Mifty</a></li>
                            <li class="breadcrumb-item"><a href="#">Tables</a></li>
                            <li class="breadcrumb-item active">Department</li>
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
                                @can('dep.create')
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                        data-bs-target="#exampleModalScrollable">
                                        ADD DEPARTMENT
                                    </button>
                                @endcan
                        </div>

                        <!-- Card Body -->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped datatable" id="datatable_2">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Department Name</th>
                                            <th>Remark</th>
                                            <th>View</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>Create</th>
                                            <th>Last Modified by</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Modified Date/Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle" id="departmentTableBody">
                                        @can('dep.view')
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    <div class="spinner-border spinner-border-custom-5 border-info" role="status"></div>
                                                </td>
                                            </tr>
                                        @endcan
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
                        <h6 class="modal-title m-0" id="exampleModalScrollableTitle">Add Department</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="departmentForm">
                            @csrf
                            <div class="mb-3">
                                <label for="departmentName" class="form-label">Department Name</label>
                                <input type="text" class="form-control mb-2" id="departmentName"
                                    placeholder="Enter Your New Department" name="depname">

                                <label for="departmentRemark" class="form-label">Department Remark</label>
                                <input type="text" class="form-control mb-3" id="departmentRemark"
                                    placeholder="Enter Department Remark" name="depremark">

                                <label for="departmentRemark" class="form-label">Access</label>
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchview"
                                            name="depview" value="1">
                                        <label class="form-check-label" for="customSwitchview">View</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchedit"
                                            name="depedit" value="1">
                                        <label class="form-check-label" for="customSwitchedit">Edit</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchdelete"
                                            name="depdelete" value="1">
                                        <label class="form-check-label" for="customSwitchdelete">Delete</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchcreate"
                                            name="depcreate" value="1">
                                        <label class="form-check-label" for="customSwitchcreate">Create</label>
                                    </div>
                                </div>

                                <label for="departmentRemark" class="form-label">Access Menu</label>
                                <div class="border rounded p-3">
                                    <div id="menuContainer">
                                        <div class="spinner-border spinner-border-custom-5 border-info" role="status"></div>
                                    </div>
                                </div>
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
                        <h6 class="modal-title m-0" id="exampleModalScrollableTitle">Update Department</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="updateDepartmentFormElement">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" id="updateDepId" name="id">
                                <label for="departmentName" class="form-label">Department Name</label>
                                <input type="text" class="form-control mb-2" id="departmentName"
                                    placeholder="Enter Your New Department" name="depname">

                                <label for="departmentRemark" class="form-label">Department Remark</label>
                                <input type="text" class="form-control mb-3" id="departmentRemark"
                                    placeholder="Enter Department Remark" name="depremark">

                                <label for="departmentRemark" class="form-label">Access</label>
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchview"
                                            name="depview" value="1">
                                        <label class="form-check-label" for="customSwitchview">View</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchedit"
                                            name="depedit" value="1">
                                        <label class="form-check-label" for="customSwitchedit">Edit</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchdelete"
                                            name="depdelete" value="1">
                                        <label class="form-check-label" for="customSwitchdelete">Delete</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchcreate"
                                            name="depcreate" value="1">
                                        <label class="form-check-label" for="customSwitchcreate">Create</label>
                                    </div>
                                </div>

                                <label for="departmentRemark" class="form-label">Access Menu</label>
                                <div class="border rounded p-3">
                                    <div id="menuContainers">
                                        <div class="spinner-border spinner-border-custom-5 border-info" role="status"></div>
                                    </div>
                                </div>
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


<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
    }

    const urlViewDep = "{{ route('view.dep') }}";               
    const urlNewDepartment = "{{ route('new.department') }}";  
    const urlGetDepartmentBase = "{{ url('admin/departments') }}"; 

    // reusable row builder function (keeps ids unique)
    function buildRow(dep) {
        return `
            <tr id="row-${dep.id}">
                <td>${dep.department_name}</td>
                <td>${dep.remark}</td>
                <td class="text-center">${dep.view ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                <td class="text-center">${dep.edit ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                <td class="text-center">${dep.delete ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                <td class="text-center">${dep.create ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                <td>${dep.user ? dep.user.name : "Unknown User"}</td>
                <td>${dep.modified_at ? new Date(dep.modified_at).toLocaleString() : '-'}</td>
                <td class="text-end">
                    ${dep.canEdit ? `<a href="#" class="edit-btn" data-id="${dep.id}" data-bs-toggle="modal" data-bs-target="#updateDepartmentForm"><i class="las la-pen text-secondary font-16"></i></a>` : ""}
                    ${dep.canDelete ? `<a href="#" class="delete-btn" data-id="${dep.id}"><i class="las la-trash-alt text-secondary font-16"></i></a>` : ""}
                </td>
            </tr>
        `;
    }

    // ---------- Add Department ----------
    document.getElementById("departmentForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        axios.post(urlNewDepartment, formData)
            .then(response => {
                if (response.data && response.data.department) {
                    const dep = response.data.department;
                    // append row
                    document.querySelector("#departmentTableBody").insertAdjacentHTML("beforeend", buildRow(dep));

                    // hide modal
                    const modalEl = document.getElementById('exampleModalScrollable');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();

                    form.reset();
                } else {
                    console.warn('Unexpected response', response);
                    alert('Saved but unexpected response');
                }
            })
            .catch(err => {
                console.error('Add department error', err);
                // if Laravel validation errors:
                if (err.response && err.response.data && err.response.data.errors) {
                    const errs = err.response.data.errors;
                    let msg = '';
                    Object.keys(errs).forEach(k => {
                        msg += errs[k].join(', ') + "\n";
                    });
                    alert(msg);
                } else {
                    alert('Error saving department');
                }
            });
    });

    // ---------- Update Department (PUT) ----------
    document.getElementById("updateDepartmentFormElement").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = this;
        const id = document.getElementById("updateDepId").value;
        const url = `${urlGetDepartmentBase}/${id}`;
        const formData = new FormData(form);

        axios.post(
            url,
            formData,
            {
                 headers: {
                     "X-HTTP-Method-Override": "PUT" 
                    }
            })
            .then(res => {
                if (res.data && res.data.department) {
                    const dep = res.data.department;
                    const row = document.querySelector(`#row-${dep.id}`);
                    if (row) row.outerHTML = buildRow(dep);

                    const modalEl = document.getElementById('updateDepartmentForm');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();
                } else {
                    console.warn('Unexpected update response', res);
                }
            })
            .catch(err => {
                console.error('Update department error', err);
                alert('Error updating department');
            });
    });

    // ---------- Delete ----------
    document.addEventListener("click", function (e) {
        if (e.target.closest(".delete-btn")) {
            e.preventDefault();
            const id = e.target.closest(".delete-btn").dataset.id;
            if (!confirm("Are you sure?")) return;
            const url = `${urlGetDepartmentBase}/${id}`;
            axios.delete(url)
                .then(() => {
                    const row = document.getElementById(`row-${id}`);
                    if (row) row.remove();
                })
                .catch(err => {
                    console.error('Delete error', err);
                    alert('Error deleting department');
                });
        }
    });

    // ---------- Edit button (fill update modal) ----------
    document.addEventListener("click", function (e) {
        if (e.target.closest(".edit-btn")) {
            e.preventDefault();
            const id = e.target.closest(".edit-btn").dataset.id;
            const url = `${urlGetDepartmentBase}/${id}`;

            axios.get(url)
                .then(res => {

                    console.log('GET department response', res);
                    if (!res.data || !res.data.department) {
                        throw new Error('Invalid response for department');
                    }

                    const dep = res.data.department;
                    const menuData = res.data.menu || [];
                    const accessIds = Array.isArray(res.data.menuAccess) ? res.data.menuAccess.map(String) : [];

                    // fill update form fields by name inside the update form (avoid duplicate id conflicts)
                    const updateForm = document.getElementById('updateDepartmentFormElement');
                    updateForm.querySelector("[name='id']").value = dep.id;
                    updateForm.querySelector("[name='depname']").value = dep.department_name || '';
                    updateForm.querySelector("[name='depremark']").value = dep.remark || '';
                    if (updateForm.querySelector("[name='depview']")) updateForm.querySelector("[name='depview']").checked = !!dep.view;
                    if (updateForm.querySelector("[name='depedit']")) updateForm.querySelector("[name='depedit']").checked = !!dep.edit;
                    if (updateForm.querySelector("[name='depdelete']")) updateForm.querySelector("[name='depdelete']").checked = !!dep.delete;
                    if (updateForm.querySelector("[name='depcreate']")) updateForm.querySelector("[name='depcreate']").checked = !!dep.create;

                    // Build menu checkboxes for update modal
                    let html = '';
                    // menuData might be an array OR object (grouped). Handle both.
                    if (Array.isArray(menuData)) {
                        menuData.forEach(item => {
                            const checked = accessIds.includes(String(item.id)) ? 'checked' : '';
                            html += `
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="submenu${item.id}_upd" name="accessmenu[]" value="${item.id}" ${checked}>
                                    <label class="form-check-label" for="submenu${item.id}_upd">${item.name ?? item.submenu ?? item.title}</label>
                                </div>
                            `;
                        });
                    } else {
                        // grouped: object with keys, each is array
                        Object.entries(menuData).forEach(([group, items]) => {
                            html += `<div class="mb-2"><h6 class="fw-bold">${group}</h6><div class="ms-2">`;
                            items.forEach(item => {
                                const checked = accessIds.includes(String(item.id)) ? 'checked' : '';
                                html += `
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="submenu${item.id}_upd" name="accessmenu[]" value="${item.id}" ${checked}>
                                        <label class="form-check-label" for="submenu${item.id}_upd">${item.name ?? item.submenu ?? item.title}</label>
                                    </div>
                                `;
                            });
                            html += `</div></div><hr/>`;
                        });
                    }

                    document.getElementById('menuContainers').innerHTML = html;
                })
                .catch(err => {
                    console.error('Error fetching department for edit', err);
                    document.getElementById('menuContainers').innerHTML = `<p class="text-danger">Error loading menus</p>`;
                    alert('Error loading department data. Check console/network tab.');
                });
        }
    });

    // ---------- Load all departments + menus on page load ----------
    function loadAll() {
        axios.get(urlViewDep)
            .then(response => {
                console.log('viewdep response', response);
                const departments = response.data.department || [];
                const menu = response.data.menu || [];

                // Build table rows
                let rows = '';
                departments.forEach(dep => {
                    rows += buildRow(dep);
                });
                document.getElementById("departmentTableBody").innerHTML = rows || `<tr><td colspan="9" class="text-center">No records</td></tr>`;

                // Build menu checkboxes for the CREATE modal (flat or grouped)
                let html = '';
                if (Array.isArray(menu)) {
                    menu.forEach(m => {
                        html += `
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="menu${m.id}" name="accessmenu[]" value="${m.id}">
                                <label class="form-check-label" for="menu${m.id}">${m.name ?? m.submenu ?? m.title}</label>
                            </div>
                        `;
                    });
                } else {
                    Object.entries(menu).forEach(([group, items]) => {
                        html += `<div class="mb-2"><h6 class="fw-bold">${group}</h6><div class="ms-2">`;
                        items.forEach(item => {
                            html += `
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu${item.id}" name="accessmenu[]" value="${item.id}">
                                    <label class="form-check-label" for="menu${item.id}">${item.name ?? item.submenu ?? item.title}</label>
                                </div>
                            `;
                        });
                        html += `</div></div><hr/>`;
                    });
                }
                document.getElementById("menuContainer").innerHTML = html || `<p class="text-muted">No menus available</p>`;
            })
            .catch(error => {
                console.error('Error loading viewdep', error);
                document.getElementById("departmentTableBody").innerHTML = `<tr><td colspan="9" class="text-danger text-center">Error loading departments</td></tr>`;
                document.getElementById("menuContainer").innerHTML = `<p class="text-danger">Error loading menus</p>`;

                // Helpful debug alert — remove in production
                if (error.response) {
                    // show server response body / status
                    console.warn('Server responded with', error.response.status, error.response.data);
                } else {
                    console.warn('Network or CORS error', error);
                }
            });
    }

    // call on load
    loadAll();

</script>

@include('admin.footer')