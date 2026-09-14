@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
    <div class="card overflow-auto">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Peminjaman</h5>
                <a href="javascript:void(0)" class="btn btn-success" id="btn-create-t">
                    TAMBAH
                </a>
            </div>

            <table class="table table-borderless" id="table-transaksi">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="table-transaksi">
                    @foreach($transaksi as $t)
                        <tr id="index_{{ $t->id }}">
                            <td>{{ $t->user->name }}</td>
                            <td>{{ $t->buku->judul }}</td>
                            <td>{{ $t->tgl_pinjam }}</td>
                            <td>{{ $t->due_date }}</td>
                            <td>{{ $t->status }}</td>
                            <td>
                                @if($t->status != 'dikembalikan')
                                    <a href="javascript:void(0)" data-id="{{ $t->id }}"
                                       class="btn btn-success btn-sm btn-kembali-t">KEMBALI</a>
                                @endif

                                <a href="javascript:void(0)" data-id="{{ $t->id }}"
                                   class="btn btn-primary btn-sm btn-edit-t">EDIT</a>

                                <a href="javascript:void(0)" data-id="{{ $t->id }}"
                                   class="btn btn-danger btn-sm btn-delete-t">DELETE</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('components.modal-transaksi')
@endsection

@section('scripts')
    <script>
    $(document).ready(function () {
        let table = $('#table-transaksi').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            order: [[2, 'desc']],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
            zeroRecords: 'Data tidak ditemukan'
            }
        });
        // CREATE
        $(document).on('click', '#btn-create-t', function () {
            $('#transaksi-id').val('');
            $('#user_id,#buku_id,#tgl_pinjam,#due_date').val('');
            $('#status').val('dipinjam');
            clearValidation();

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('modal-transaksi')
            ).show();
        });

        // SAVE
        $(document).on('click', '#save-transaksi', function (e) {
            e.preventDefault();
            clearValidation();
            let id = $('#transaksi-id').val();

            let data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                user_id: $('#user_id').val(),
                buku_id: $('#buku_id').val(),
                tgl_pinjam: $('#tgl_pinjam').val(),
                due_date: $('#due_date').val(),
                status: $('#status').val()
            };

            let url = id ? `/transaksi/${id}` : "{{ route('transaksi.store') }}";

            if (id) data._method = 'PUT';

            $.ajax({
                url: url,
                type: 'POST',
                data: data,

                success: function (response) {
                    let t = response.data;

                    let option = $('#buku_id option[value="' + t.buku_id + '"]');
                    let stok = option.data('stok') - 1;

                    if (stok <= 0) {
                        option.remove();
                    } else {
                        option.attr('data-stok', stok);
                        option.data('stok', stok);
                        option.text(t.buku.judul + ' (Stok: ' + stok + ')');                        
                    }

                    if (id) {
                        let row = table.row($('#index_' + id));
                        row.data([
                            t.user.name,
                            t.buku.judul,
                            t.tgl_pinjam,
                            t.due_date,
                            t.status,
                            `
                            ${t.status != 'dikembalikan'
                                ? `<a href="javascript:void(0)" data-id="${t.id}" class="btn btn-success btn-sm btn-kembali-t">KEMBALI</a>`
                                : ''
                            }
                            <a href="javascript:void(0)" data-id="${t.id}" class="btn btn-primary btn-sm btn-edit-t">EDIT</a>
                            <a href="javascript:void(0)" data-id="${t.id}" class="btn btn-danger btn-sm btn-delete-t">DELETE</a>
                            `
                        ]).draw(false);
                    } else {
                        let row = table.row.add([
                        t.user.name,
                        t.buku.judul,
                        t.tgl_pinjam,
                        t.due_date,
                        t.status,
                        `
                        <a href="javascript:void(0)" data-id="${t.id}" class="btn btn-success btn-sm btn-kembali-t">KEMBALI</a>
                        <a href="javascript:void(0)" data-id="${t.id}" class="btn btn-primary btn-sm btn-edit-t">EDIT</a>
                        <a href="javascript:void(0)" data-id="${t.id}" class="btn btn-danger btn-sm btn-delete-t">DELETE</a>
                        `
                    ]);
                    $(row.node()).attr('id', 'index_' + t.id);
                    row.draw(false);
                    }

                    bootstrap.Modal.getInstance(
                        document.getElementById('modal-transaksi')
                    )?.hide();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: id ? 'Transaksi berhasil diubah' : 'Transaksi berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1800,
                        timerProgressBar: true
                    });
                },

                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors || {}, function (field, messages) {
                            showError('#' + field, '#alert-' + field, messages[0]);
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    }
                }
            });
        });

        // EDIT
        $(document).on('click', '.btn-edit-t', function () {
            let id = $(this).data('id');

            $.get(`/transaksi/${id}/edit`, function (response) {
                let t = response.data;

                $('#transaksi-id').val(t.id);
                $('#user_id').val(t.user_id);
                $('#buku_id').val(t.buku_id);
                $('#tgl_pinjam').val(t.tgl_pinjam);
                $('#due_date').val(t.due_date);
                $('#status').val(t.status);

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('modal-transaksi')
                ).show();
            });
        });

        // KEMBALI
        $(document).on('click', '.btn-kembali-t', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Kembalikan buku?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'YA, KEMBALIKAN',
                cancelButtonText: 'BATAL'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: `/transaksi/${id}/kembali`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT'
                    },

                    success: function (response) {
                        let row = $('#index_' + id);
                        let t = response.data;

                        console.log('TRANSAKSI:', t);
                        console.log('BUKU:', t.buku);

                        row.find('td:eq(4)').text('dikembalikan');
                        row.find('.btn-kembali-t').remove();

                        let option = $('#buku_id option[value="' + t.buku_id + '"]');

                        if (option.length) {
                            option.attr('data-stok', t.buku.stok);
                            option.data('stok', t.buku.stok);
                            option.text(t.buku.judul + ' (Stok: ' + t.buku.stok + ')');
                        }

                        else {
                            $('#buku_id').append(
                                `<option value="${t.buku_id}" data-stok="${t.buku.stok}">
                                    ${t.buku.judul} (Stok: ${t.buku.stok})
                                </option>`
                            );
                        }

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Buku berhasil dikembalikan',
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true
                        });
                    },

                    error: function (xhr) {
                        console.log('ERROR:', xhr.responseText);
                    }
                });
            });
        });

        // DELETE
        $(document).on('click', '.btn-delete-t', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Hapus transaksi?',
                text: 'Data tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'YA, HAPUS',
                cancelButtonText: 'BATAL'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: `/transaksi/${id}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },

                    success: function (response) {
                        $('#index_' + id).fadeOut(300, function () {
                            $(this).remove();
                        });

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: 'Transaksi berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });

        function showError(input, alert, message) {
            $(input).addClass('is-invalid');
            $(alert).text(message);
        }

        function clearValidation() {
            $('#modal-transaksi .form-control').removeClass('is-invalid');
            $('#modal-transaksi .invalid-feedback').text('');
        }
    });
    </script>
@endsection