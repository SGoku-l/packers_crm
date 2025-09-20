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
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModalScrollable">
                                ADD DEPARTMENT
                            </button>
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
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="spinner-border spinner-border-custom-5 border-info" role="status"></div>
                                            </td>
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

        <!-- SCRIPT -->
        <script>
            // reusable row builder function
            function buildRow(dep) {
                return `
                    <tr id="row-${dep.id}">
                        <td>${dep.department_name}</td>
                        <td>${dep.remark}</td>
                        <td>${dep.view ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                        <td>${dep.edit ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                        <td>${dep.delete ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                        <td>${dep.create ? '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' : '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                        <td>${dep.user ? dep.user.name : "Unknown User"}</td>
                        <td>${new Date(dep.modified_at).toLocaleString()}</td>
                        <td class="text-end">
                            <a href="#" class="edit-btn" data-id="${dep.id}" data-bs-toggle="modal" data-bs-target="#updateDepartmentForm">
                                <i class="las la-pen text-secondary font-16"></i>
                            </a>
                            <a href="#" class="delete-btn" data-id="${dep.id}">
                                <i class="las la-trash-alt text-secondary font-16"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }

            // Handle update department form
            document.getElementById("updateDepartmentFormElement").addEventListener("submit", function(e) {
                e.preventDefault();
                let id = document.getElementById("updateDepId").value;
                let formData = new FormData(this);

                axios.post(`departments/${id}`, formData, {
                    headers: { 
                        "X-HTTP-Method-Override": "PUT" 
                    }
                })
                .then(res => {
                    const dep = res.data.department;

                    // Replace row with updated data
                    document.querySelector(`#row-${id}`).outerHTML = buildRow(dep);

                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById("updateDepartmentForm")).hide();
                })
                .catch(err => console.error(err));
            });

            // Handle delete button click
            document.addEventListener("click", function(e) {
                if (e.target.closest(".delete-btn")) {
                    e.preventDefault();
                    let id = e.target.closest(".delete-btn").dataset.id;

                    if (!confirm("Are you sure you want to delete this department?")) return;

                    axios.delete(`departments/${id}`)
                        .then(() => {
                            document.getElementById(`row-${id}`).remove();
                        })
                        .catch(err => console.error(err));
                }
            });

            // Handle edit button click
            document.addEventListener("click", function(e) {
                if (e.target.closest(".edit-btn")) {
                    e.preventDefault();
                    let id = e.target.closest(".edit-btn").dataset.id;

                    axios.get(`departments/${id}`)
                        .then(res => {
                            let dep = res.data.department;   // department object
                            let menuData = res.data.menu;    // all menus
                            let accessIds = res.data.menuAccess.map(String); // only access ids from DB

                            // Fill modal fields
                            document.getElementById("updateDepId").value = dep.id;
                            document.querySelector("#updateDepartmentForm [name='depname']").value = dep.department_name;
                            document.querySelector("#updateDepartmentForm [name='depremark']").value = dep.remark;

                            document.querySelector("#updateDepartmentForm [name='depview']").checked = dep.view;
                            document.querySelector("#updateDepartmentForm [name='depedit']").checked = dep.edit;
                            document.querySelector("#updateDepartmentForm [name='depdelete']").checked = dep.delete;
                            document.querySelector("#updateDepartmentForm [name='depcreate']").checked = dep.create;

                            // Build all menus, mark only checked ones
                            let html = "";
                            Object.entries(menuData).forEach(([menuName, submenus]) => {
                                html += `
                                    <div class="mb-3">
                                        <h6 class="fw-bold">${menuName}</h6>
                                        <div class="ms-3">
                                `;
                                submenus.forEach(submenu => {
                                    let checked = accessIds.includes(String(submenu.id)) ? "checked" : "";
                                    html += `
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                id="submenu${submenu.id}" name="accessmenu[]"
                                                value="${submenu.id}" ${checked}>
                                            <label class="form-check-label" for="submenu${submenu.id}">
                                                ${submenu.submenu}
                                            </label>
                                        </div>
                                    `;
                                });
                                html += `
                                        </div>
                                    </div>
                                    <hr>
                                `;
                            });

                            document.getElementById("menuContainers").innerHTML = html;
                        })
                        .catch(err => {
                            document.getElementById("menuContainers").innerHTML =
                                `<p class="text-danger">Error loading menus</p>`;
                            console.error(err);
                        });
                }
            });
   
            // Handle add department form
            document.getElementById("departmentForm").addEventListener("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                axios.post("{{ route('new.department') }}", formData)
                    .then(response => {
                        const dep = response.data.department;

                        document.querySelector("#departmentTableBody").insertAdjacentHTML("beforeend", buildRow(dep));

                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalScrollable'));
                        modal.hide();

                        // Reset form
                        document.getElementById("departmentForm").reset();
                    })
                    .catch(error => {
                        alert("Error saving department");
                        console.error(error);
                    });
            });

            // Load all departments + menus
            axios.get("viewdep")
                .then(response => {
                    const departments = response.data.department;
                    let rows = "";

                    departments.forEach(dep => {
                        rows += buildRow(dep);
                    });

                    document.getElementById("departmentTableBody").innerHTML = rows;

                    const menuData = response.data.menu;
                    let html = "";

                    Object.entries(menuData).forEach(([menuName, submenus]) => {
                        html += `
                            <div class="mb-3">
                                <h6 class="fw-bold">${menuName}</h6>
                                <div class="ms-3">
                        `;
                        submenus.forEach(submenu => {
                            html += `
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        id="submenu${submenu.id}" name="accessmenu[]"
                                        value="${submenu.id}">
                                    <label class="form-check-label" for="submenu${submenu.id}">
                                        ${submenu.submenu}
                                    </label>
                                </div>
                            `;
                        });
                        html += `
                                </div>
                            </div>
                            <hr>
                        `;
                    });

                    document.getElementById("menuContainer").innerHTML = html;
                })
                .catch(error => {
                    document.getElementById("departmentTableBody").innerHTML =
                        `<tr><td colspan="9" class="text-danger text-center">Error loading departments</td></tr>`;
                    document.getElementById("menuContainer").innerHTML =
                        `<p class="text-danger">Error loading menus</p>`;
                    console.error(error);
                });
        </script>
@include('admin.footer')