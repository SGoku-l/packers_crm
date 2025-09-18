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
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">
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
                                            <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle">
                                        @foreach ($department as $dep)
                                        
                                            <tr>
                                                <td>{{ $dep->department_name }}</td>
                                                <td>{{ $dep->remark }}</td>
                                                @if ($dep->view === 1)
                                                    <td><input type="checkbox" name="view"></td>
                                                @endif
                                                <td><input type="checkbox" name="edit"></td>
                                                <td><input type="checkbox" name="delete"></td>
                                                <td><input type="checkbox" name="update"></td>
                                                <td>855</td>
                                                <td>2025/09/19</td>
                                            </tr>
                                            
                                        @endforeach 
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
                <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
        <div class="modal fade" id="exampleModalScrollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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
                                <input type="text" class="form-control mb-2" id="departmentName" placeholder="Enter Your New Department" name="depname">

                                <label for="departmentRemark" class="form-label">Department Remark</label>
                                <input type="text" class="form-control mb-3" id="departmentRemark" placeholder="Enter Department Remark" name="depremark">

                                <!-- Switches in one line -->
                                 
                                <label for="departmentRemark" class="form-label">Access</label>
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchview" name="depview" value="1">
                                        <label class="form-check-label" for="customSwitchview">View</label>
                                    </div>

                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchedit" name="depedit"  value="1">
                                        <label class="form-check-label" for="customSwitchedit">Edit</label>
                                    </div>

                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchdelete" name="depdelete"  value="1">
                                        <label class="form-check-label" for="customSwitchdelete">Delete</label>
                                    </div>

                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="customSwitchcreate" name="depcreate"  value="1">
                                        <label class="form-check-label" for="customSwitchcreate">Create</label>
                                    </div>
                                </div>
                                <label for="departmentRemark" class="form-label">Access Menu</label>
                                <div class="startbar-menu">
                                    <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                                        <div class="d-flex align-items-start flex-column w-100">

                                            <!-- Loop Menus -->
                                            <ul class="navbar-nav mb-auto w-100">
                                                <div class="row text-center">
                                                    @foreach($menu as $menuName => $submenus)
                                                        <div class="col-md-4 col-sm-6 mb-4">
                                                            <li class="nav-item mb-3">
                                                                <!-- Menu Name -->
                                                                <span class="fw-bold d-block mb-2">{{ $menuName }}</span>

                                                                <!-- Submenu -->
                                                                <div class="row g-3">
                                                                    <div class="col-md-4 col-sm-6">
                                                                        @foreach ($submenus as $submenu)
                                                                        
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" id="submenu{{ $submenu->id }}" name="accessmenu[]" value="{{ $submenu->id }}">
                                                                            <label class="form-check-label" for="submenu{{ $submenu->id }}">
                                                                                {{ $submenu->submenu }}
                                                                            </label>
                                                                        </div>
                                                                        
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </div>    
                                                    @endforeach
                                                    
                                                </div>
                                            </ul><!-- end navbar-nav -->
                                        </div>
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

    </div><!-- page-content -->
</div><!-- page-wrapper -->

@include('admin.footer')
