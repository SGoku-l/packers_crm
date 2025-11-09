 axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
    }

    const urlViewDep = window.urlViewDep;
    const urlNewDepartment = window.urlNewDepartment;
    const urlGetDepartmentBase = window.urlGetDepartmentBase;

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
    document.addEventListener("DOMContentLoaded", function () {
        const departmentForm = document.getElementById("departmentForm");
        if (!departmentForm) return;

        departmentForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);

            axios.post(urlNewDepartment, formData)
                .then(response => {
                    const data = response.data || {};

                    if (data.status === true && data.department) {
                        const dep = data.department;
                        const tableBody = document.querySelector("#departmentTableBody");
                        if (tableBody) {
                            tableBody.insertAdjacentHTML("beforeend", buildRow(dep));
                        }

                        const modalEl = document.getElementById('exampleModalScrollable');
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        modal.hide();

                        form.reset();
                        showToast('success', data.message || 'Department Created Successfully.');
                    } else {
                        console.warn('Unexpected response:', data);
                        showToast('warning', 'Saved but unexpected response structure.');
                    }
                })
                .catch(error => {
                    console.error('Add Department Error:', error);

                    if (error.response && error.response.status === 200 && error.response.data) {
                        const data = error.response.data;
                        if (data.status === true) {
                            showToast('success', data.message || 'Department added successfully.');
                            return;
                        }
                    }

                    if (error.response && error.response.data && error.response.data.message) {
                        showToast('danger', error.response.data.message);
                    } else if (error.message) {
                        showToast('danger', error.message);
                    } else {
                        showToast('danger', 'Unknown error while saving department.');
                    }
                });
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

                    showToast('success', 'Department updated successfully.');
                } else {
                    console.warn('Unexpected update response', res);
                    showToast('warning', 'Updated but unexpected response.');
                }
            })
            .catch(err => {
                console.error('Update department error', err);
                showToast('danger', 'Error updating department.');
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
                    showToast('success', 'Department deleted successfully.');
                })
                .catch(err => {
                    console.error('Delete error', err);
                    showToast('danger', 'Error deleting department.');
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

                    const updateForm = document.getElementById('updateDepartmentFormElement');
                    updateForm.querySelector("[name='id']").value = dep.id;
                    updateForm.querySelector("[name='depname']").value = dep.department_name || '';
                    updateForm.querySelector("[name='depremark']").value = dep.remark || '';
                    if (updateForm.querySelector("[name='depview']")) updateForm.querySelector("[name='depview']").checked = !!dep.view;
                    if (updateForm.querySelector("[name='depedit']")) updateForm.querySelector("[name='depedit']").checked = !!dep.edit;
                    if (updateForm.querySelector("[name='depdelete']")) updateForm.querySelector("[name='depdelete']").checked = !!dep.delete;
                    if (updateForm.querySelector("[name='depcreate']")) updateForm.querySelector("[name='depcreate']").checked = !!dep.create;

                    let html = '';
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
                    showToast('info', 'Department details loaded for editing.');
                })
                .catch(err => {
                    console.error('Error fetching department for edit', err);
                    document.getElementById('menuContainers').innerHTML = `<p class="text-danger">Error loading menus</p>`;
                    showToast('danger', 'Error loading department data.');
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

                let rows = '';
                departments.forEach(dep => {
                    rows += buildRow(dep);
                });
                document.getElementById("departmentTableBody").innerHTML = rows || `<tr><td colspan="9" class="text-center">No records</td></tr>`;

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
                showToast('success', 'Departments loaded successfully.');
            })
            .catch(error => {
                console.error('Error loading viewdep', error);
                document.getElementById("departmentTableBody").innerHTML = `<tr><td colspan="9" class="text-danger text-center">Error loading departments</td></tr>`;
                document.getElementById("menuContainer").innerHTML = `<p class="text-danger">Error loading menus</p>`;
                showToast('danger', 'Error loading departments or menus.');
            });
    }

    loadAll();