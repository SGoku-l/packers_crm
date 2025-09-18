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
                                            <th data-type="date" data-format="YYYY/DD/MM">Modified Data/Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle" id="departmentTableBody">

                                        <tr>
                                            <td colspan="8" class="text-center"><div class="spinner-border spinner-border-custom-5 border-info" role="status"></div> </td>
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

        <!-- Right Sidebar (offcanvas) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
            <div class="offcanvas-header border-bottom justify-content-between">
                <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
                <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <h6>Account Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                    </div>
                </div>
                <h6>General Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
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
                        <form method="POST" action="{{ route('new.department') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="departmentName" class="form-label">Department Name</label>
                                <input type="text" class="form-control mb-2" id="departmentName"
                                    placeholder="Enter Your New Department" name="depname">

                                <label for="departmentRemark" class="form-label">Department Remark</label>
                                <input type="text" class="form-control mb-3" id="departmentRemark"
                                    placeholder="Enter Department Remark" name="depremark">

                                <!-- Switches in one line -->

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
                                <div class="border rounded p-3" >
                                  <div id="menuContainer"><div class="spinner-border spinner-border-custom-5 border-info" role="status"></div> </div>
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




        <script>
            axios.get("viewdep")
                .then(response => {
                    const departments = response.data.department;
                    let rows = "";

                    departments.forEach(dep => {
                        rows += `
                        <tr>
                            <td>${dep.department_name}</td>
                            <td>${dep.remark}</td>
                            <td>${dep.view ?
                                                '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' :
                                                '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                            <td>${dep.edit ?
                                                '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' :
                                                '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                            <td>${dep.delete ?
                                                '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' :
                                                '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                            <td>${dep.create ?
                                                '<i class="fa-solid fa-square-check" style="color:#5bb450;"></i>' :
                                                '<i class="fa-solid fa-square-xmark" style="color:#f01e2c;"></i>'}</td>
                            <td>${dep.user?.name ?? 'Unknown User'}</td>
                            <td>${dep.modified_at}</td>
                        </tr>
                        `;
                    });

                    document.getElementById("departmentTableBody").innerHTML = rows;
                    const menuData = response.data.menu;
                    let html = "";

                    // Loop menu groups
                    Object.entries(menuData).forEach(([menuName, submenus]) => {
                    html += `
                        <div class="mb-3">
                        <h6 class="fw-bold">${menuName}</h6>
                        <div class="ms-3">
                    `;

                    // Loop submenus
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
                        `<tr><td colspan="8" class="text-danger text-center">Error loading departments</td></tr>`;
                    document.getElementById("menuContainer").innerHTML =
                    `<p class="text-danger">Error loading menus</p>`;
                    console.error(error);
                });
               
        </script>
        @include('admin.footer')