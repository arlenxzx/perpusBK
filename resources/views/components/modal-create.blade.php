<div
    class="modal fade"
    id="modal-create"
    tabindex="-1"
    aria-labelledby="modalCreateLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modalCreateLabel">
                    Tambah Buku
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul" class="form-label">
                        Judul Buku
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="judul"
                        name="judul">

                    <div
                        class="invalid-feedback"
                        id="alert-judul">
                    </div>

                </div>
                <div class="mb-3">
                    <label for="penulis" class="form-label">
                        Penulis
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        id="penulis"
                        name="penulis">

                    <div
                        class="invalid-feedback"
                        id="alert-penulis">
                    </div>

                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">
                        Kategori
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        id="kategori"
                        name="kategori">

                    <div
                        class="invalid-feedback"
                        id="alert-kategori">
                    </div>

                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        Deskripsi
                    </label>
                    <textarea
                        class="form-control"
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"></textarea>

                    <div
                        class="invalid-feedback"
                        id="alert-deskripsi">
                    </div>

                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">
                        Stok
                    </label>
                    <input
                        type="number"
                        class="form-control"
                        id="stok"
                        name="stok"
                        min="0">

                    <div
                        class="invalid-feedback"
                        id="alert-stok">
                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    TUTUP
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="store">

                    <span id="store-text">
                        SIMPAN
                    </span>

                    <span
                        id="store-loading"
                        class="spinner-border spinner-border-sm d-none"
                        role="status">
                    </span>

                </button>

            </div>

        </div>

    </div>

</div>