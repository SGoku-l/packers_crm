axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

// Get routes & permissions from Blade
const api = window.apiRoutes;
const userPermissions = window.userPermissions || [];

const tableBody = document.getElementById('dataTableBody');
const columnTitle = document.getElementById('columnTitle');
const addBtn = document.getElementById('addBtn');
const modalTitle = document.getElementById('modalTitle');
const nameLabel = document.getElementById('nameLabel');
const dataTypeInput = document.getElementById('dataType');
const nameInput = document.getElementById('nameInput');
const statusInput = document.getElementById('statusInput');
const saveBtn = document.getElementById('saveBtn');

let editId = null;

// Load data dynamically
function loadData(type) {
    tableBody.innerHTML = `<tr><td colspan="5"><div class="spinner-border text-primary" role="status"></div></td></tr>`;
    axios.get(api[type].fetch)
        .then(res => {
            const data = res.data.data || [];
            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5">No records found</td></tr>`;
                return;
            }

            let rows = '';
            data.forEach((item, index) => {
                const statusBadge = item.status === 'active'
                    ? `<span class="badge bg-success">Active</span>`
                    : `<span class="badge bg-secondary">Inactive</span>`;

                const toggleBtn = item.status === 'active'
                    ? `<button class="btn btn-sm btn-outline-warning toggle-status" data-id="${item.id}" data-status="inactive">Deactivate</button>`
                    : `<button class="btn btn-sm btn-outline-success toggle-status" data-id="${item.id}" data-status="active">Activate</button>`;

                const nameField = type === 'status' ? item.lead_status : type === 'source' ? item.source_name : item.method;

                // Permission-based buttons
                let actions = `${toggleBtn}`;
                if (userPermissions.includes('lead.edit')) {
                    actions += `
                        <button class="btn btn-sm btn-outline-secondary edit-btn" 
                                data-id="${item.id}" 
                                data-name="${nameField}" 
                                data-status="${item.status}">
                            <i class="las la-pen"></i>
                        </button>`;
                }
                if (userPermissions.includes('lead.delete')) {
                    actions += `
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${item.id}">
                            <i class="las la-trash-alt"></i>
                        </button>`;
                }

                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${nameField}</td>
                        <td>${statusBadge}</td>
                        <td class="d-flex justify-content-center gap-2">${actions}</td>
                        <td>${item.updated_at ? new Date(item.updated_at).toLocaleString() : '-'}</td>
                    </tr>
                `;
            });
            tableBody.innerHTML = rows;
            attachActionHandlers(type);
        })
        .catch(err => {
            console.error(err);
            tableBody.innerHTML = `<tr><td colspan="5" class="text-danger">Error loading data</td></tr>`;
        });
}

// Attach actions (edit, delete, toggle)
function attachActionHandlers(type) {
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            editId = this.dataset.id;
            nameInput.value = this.dataset.name;
            statusInput.value = this.dataset.status;
            modalTitle.innerText = `Edit ${type}`;
            saveBtn.innerText = 'Update';
            new bootstrap.Modal(document.getElementById('addModal')).show();
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (!confirm("Are you sure to delete this record?")) return;
            axios.delete(`${api[type].delete}/${id}`)
                .then(() => loadData(type))
                .catch(err => {
                    console.error(err);
                    alert("Error deleting record");
                });
        });
    });

    document.querySelectorAll('.toggle-status').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const newStatus = this.dataset.status;
            axios.put(`${api[type].toggle}/${id}/toggle`, { status: newStatus })
                .then(() => loadData(type))
                .catch(err => {
                    console.error(err);
                    alert("Error updating status");
                });
        });
    });
}

// Handle tab switching
document.querySelectorAll('.data-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.data-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const type = this.dataset.type;
        dataTypeInput.value = type;

        if (type === 'status') {
            columnTitle.innerText = 'Lead Status';
            addBtn.innerText = 'Add Lead Status';
            modalTitle.innerText = 'Add Lead Status';
            nameLabel.innerText = 'Lead Status Name';
            document.getElementById('pageTitle').innerText = 'Lead Statuses';
        } else if (type === 'source') {
            columnTitle.innerText = 'Lead Source';
            addBtn.innerText = 'Add Lead Source';
            modalTitle.innerText = 'Add Lead Source';
            nameLabel.innerText = 'Lead Source Name';
            document.getElementById('pageTitle').innerText = 'Lead Sources';
        } else {
            columnTitle.innerText = 'Follow-Up Method';
            addBtn.innerText = 'Add Follow-Up Method';
            modalTitle.innerText = 'Add Follow-Up Method';
            nameLabel.innerText = 'Follow-Up Method Name';
            document.getElementById('pageTitle').innerText = 'Follow-Up Methods';
        }

        loadData(type);
    });
});

// Save (Create or Update)
saveBtn.addEventListener('click', function() {
    const type = dataTypeInput.value;
    const name = nameInput.value.trim();
    const status = statusInput.value;

    if (!name) return alert("Please enter a name");
    if (!status) return alert("Please select a status");

    let payload = { status: status };
    if (type === 'status') payload.lead_status = name;
    else if (type === 'source') payload.source_name = name;
    else payload.method = name;

    if (editId) {
        axios.put(`${api[type].update}/${editId}`, payload)
            .then(() => {
                bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
                nameInput.value = '';
                statusInput.value = '';
                editId = null;
                saveBtn.innerText = 'Save';
                loadData(type);
            })
            .catch(err => {
                console.error(err);
                alert("Error updating record");
            });
    } else {
        axios.post(api[type].store, payload)
            .then(() => {
                bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
                nameInput.value = '';
                statusInput.value = '';
                loadData(type);
            })
            .catch(err => {
                console.error(err);
                alert("Error saving record");
            });
    }
});

// Reset modal
document.getElementById('addModal')?.addEventListener('hidden.bs.modal', () => {
    editId = null;
    nameInput.value = '';
    statusInput.value = '';
    saveBtn.innerText = 'Save';
});

// Initial load
loadData('status');