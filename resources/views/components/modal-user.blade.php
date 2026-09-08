<div class="modal fade" id="modal-user" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="user-id">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name">
                    <div class="invalid-feedback" id="alert-name"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email">
                    <div class="invalid-feedback" id="alert-email"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                    <div class="invalid-feedback" id="alert-password"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-control" id="role">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="member">Member</option>
                    </select>
                    <div class="invalid-feedback" id="alert-role"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    TUTUP
                </button>

                <button type="button" class="btn btn-primary" id="save-user">
                    SIMPAN
                </button>
            </div>

        </div>
    </div>
</div>