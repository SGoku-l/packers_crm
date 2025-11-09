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
            // Laravel route URLs passed safely to JS
            const ADMIN_ALL_URL = "{{ route('admin.alldata') }}";
            const ADMIN_NEW_URL = "{{ route('new.admin') }}";
        </script>

        <script src="{{ asset('assets/js/api/admin-all.ajax.js') }}"></script>

@include('admin.footer')