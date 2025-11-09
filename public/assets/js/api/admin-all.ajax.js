// ================== PASSWORD TOGGLE ==================
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

// ================== TOAST UTILITIES ==================
function showToast(type, message) {
    const container = document.querySelector('.toast-container') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} fade mb-2`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = `
        <div class="toast-header">
            <img src="/assets/images/logo-sm.png" alt="" height="20" class="me-1">
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

// ================== PERMISSION FLAGS ==================
let canEdit = false;
let canDelete = false;
let canCreate = false;
let canView = false;

// ================== BUILD ROW ==================
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

// ================== UPDATE ADMIN FORM ==================
document.getElementById("updateAdminForm").addEventListener("submit", function (e) {
    e.preventDefault();
    let id = document.getElementById("updateAdminId").value;
    let formData = new FormData(this);

    axios.post(`adminup/${id}`, formData, {
        headers: { "X-HTTP-Method-Override": "PUT" }
    })
        .then(res => {
            const addm = res.data.admin;
            document.querySelector(`#row-${id}`).outerHTML = buildRow(addm);
            bootstrap.Modal.getInstance(document.getElementById("updateDepartmentForm")).hide();
            showToast('success', 'Admin updated successfully.');
        })
        .catch(err => {
            console.error(err);
            showToast('danger', 'Error updating admin.');
        });
});

// ================== DELETE ADMIN ==================
document.addEventListener("click", function (e) {
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

// ================== EDIT ADMIN ==================
document.addEventListener("click", function (e) {
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
                document.getElementById("updateAdminRole").innerHTML = `<p class="text-danger">Error loading Roles</p>`;
                console.error(err);
                showToast('danger', 'Error loading admin data.');
            });
    }
});

// ================== ADD ADMIN ==================
document.getElementById("adminForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    axios.post(ADMIN_NEW_URL, formData)
        .then(response => {
            if (response.data && response.data.status === true) {
                const add = response.data.admin;
                document.querySelector("#departmentTableBody").insertAdjacentHTML("beforeend", buildRow(add));
                bootstrap.Modal.getInstance(document.getElementById('exampleModalScrollable')).hide();
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

// ================== LOAD ALL ADMINS ==================
axios.get(ADMIN_ALL_URL)
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
    })
    .catch(error => {
        document.getElementById("departmentTableBody").innerHTML =
            `<tr><td colspan="9" class="text-danger text-center">Error loading Admin</td></tr>`;
        document.getElementById("createAdminRole").innerHTML =
            `<p class="text-danger">Error loading menus</p>`;
        console.error(error);
        showToast('danger', 'Error loading admin data.');
    });
