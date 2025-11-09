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
            window.urlViewDep = "{{ route('view.dep') }}";
            window.urlNewDepartment = "{{ route('new.department') }}";
            window.urlGetDepartmentBase = "{{ url('admin/departments') }}";
        </script>
        <script src="{{ asset('assets/js/api/department.ajax.js') }}"></script>

@include('admin.footer')