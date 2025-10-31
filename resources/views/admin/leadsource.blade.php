@include('admin.header')
@include('admin.rightsidebar')
@include('admin.leftsidebar')
@include('partials.toasts')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title & Breadcrumb -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-flex justify-content-between align-items-center">
                        <h4 class="page-title mb-0" id="pageTitle">Lead Statuses</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Mifty</a></li>
                            <li class="breadcrumb-item active">Lead Management</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">

                        <!-- Card Header -->
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="card-title mb-0">Manage Leads</h4>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm data-btn active" data-type="status">
                                    Lead Statuses
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm data-btn" data-type="source">
                                    Lead Sources
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm data-btn" data-type="method">
                                    Follow-Up Methods
                                </button>
                            </div>
                            @can('lead.create')
                            <button type="button" class="btn btn-primary btn-sm" id="addBtn" data-bs-toggle="modal" data-bs-target="#addModal">
                                Add Lead Status
                            </button>
                            @endcan
                        </div>

                        <!-- Card Body -->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center align-middle datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th id="columnTitle">Lead Status</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Modified Date/Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <tr>
                                            <td colspan="5">
                                                <div class="spinner-border text-primary" role="status"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        @can('lead.create')
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modalTitle">Add Lead Status</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
                            @csrf
                            <input type="hidden" id="dataType" name="type" value="status">
                            <div class="mb-3">
                                <label class="form-label" id="nameLabel">Lead Status Name</label>
                                <input type="text" class="form-control" name="name" id="nameInput" placeholder="Enter name">
                                <label for="statusInput">Status</label>
                                <select name="status" class="form-control mt-2" id="statusInput" required>
                                    <option value="">Select</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-sm" id="saveBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <!-- End Modal -->

    </div>
</div>

<script>
window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));

window.apiRoutes = {
    status: {
        fetch: "{{ route('lead.statuses.index') }}",
        store: "/admin/lead-statuses-store-api",
        update: "/admin/lead-statuses-update-api",
        toggle: "/admin/lead-statuses-toggle-api",
        delete: "/admin/lead-statuses-delete-api"
    },
    source: {
        fetch: "{{ route('lead.sources.index') }}",
        store: "/admin/lead-source-store-api",
        update: "/admin/lead-source-update-api",
        toggle: "/admin/lead-source-toggle-api",
        delete: "/admin/lead-source-delete-api"
    },
    method: {
        fetch: "{{ route('follow.methods.index') }}",
        store: "/admin/lead-followmethod-store-api",
        update: "/admin/lead-followmethod-update-api",
        toggle: "/admin/lead-followmethod-toggle-api",
        delete: "/admin/lead-followmethod-delete-api"
    }
};
</script>

<script src="{{ asset('assets/js/api/all-lead-statues.ajax.js') }}"></script>

@include('admin.footer')