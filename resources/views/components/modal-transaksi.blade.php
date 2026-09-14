<div class="modal fade" id="modal-transaksi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Peminjaman Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="transaksi-id">

                <div class="mb-3">
                    <label class="form-label">Peminjam</label>
                    <select class="form-control" id="user_id">
                        <option value="">Pilih Peminjam</option>
                        @foreach($user as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="alert-user_id"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Buku</label>
                    <select class="form-control" id="buku_id">
                        <option value="">Pilih Buku</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->id }}" data-stok = {{ $b->stok }}>{{ $b->judul }} (Stok: {{ $b->stok }})</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="alert-buku_id"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tgl_pinjam">
                    <div class="invalid-feedback" id="alert-tgl_pinjam"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jatuh Tempo</label>
                    <input type="date" class="form-control" id="due_date">
                    <div class="invalid-feedback" id="alert-due_date"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" id="status">
                        <option value="pending">Pending</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="expired">Expired</option>
                    </select>
                    <div class="invalid-feedback" id="alert-status"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    TUTUP
                </button>

                <button type="button" class="btn btn-primary" id="save-transaksi">
                    SIMPAN
                </button>
            </div>

        </div>
    </div>
</div>