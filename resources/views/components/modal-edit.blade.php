<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Buku</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit-id">

                <div class="mb-3">
                    <label for="edit-judul" class="form-label">
                        Judul Buku
                    </label>

                    <input type="text"
                           class="form-control"
                           id="edit-judul">

                    <div class="invalid-feedback" id="edit-alert-judul"></div>
                </div>

                <div class="mb-3">
                    <label for="edit-penulis" class="form-label">
                        Penulis
                    </label>

                    <input type="text"
                           class="form-control"
                           id="edit-penulis">

                    <div class="invalid-feedback" id="edit-alert-penulis"></div>
                </div>

                <div class="mb-3">
                    <label for="edit-kategori" class="form-label">
                        Kategori
                    </label>

                    <input type="text"
                           class="form-control"
                           id="edit-kategori">

                    <div class="invalid-feedback" id="edit-alert-kategori"></div>
                </div>

                <div class="mb-3">
                    <label for="edit-deskripsi" class="form-label">
                        Deskripsi
                    </label>

                    <textarea class="form-control"
                              id="edit-deskripsi"
                              rows="4"></textarea>

                    <div class="invalid-feedback" id="edit-alert-deskripsi"></div>
                </div>

                <div class="mb-3">
                    <label for="edit-stok" class="form-label">
                        Stok
                    </label>

                    <input type="number"
                           class="form-control"
                           id="edit-stok"
                           min="0">

                    <div class="invalid-feedback" id="edit-alert-stok"></div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    TUTUP
                </button>

                <button type="button"
                        class="btn btn-primary"
                        id="update">

                    <span id="update-text">UPDATE</span>

                    <span id="update-loading"
                          class="spinner-border spinner-border-sm d-none">
                    </span>

                </button>

            </div>

        </div>
    </div>
</div>