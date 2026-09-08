@extends('layouts.app')

@section('title', 'Buku')

@section('content')

    <div class="card recent-sales overflow-auto">

        <div class="card-body">

            <div class="body d-flex justify-content-between align-items-center">

                <h5 class="card-title">
                    Data Buku
                </h5>

                <a href="javascript:void(0)"
                   class="btn btn-success"
                   id="btn-create-b">
                    TAMBAH
                </a>

            </div>

            <table class="table table-borderless datatable">

                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="table-buku">

                    @foreach($buku as $b)

                        <tr id="index_{{ $b->id }}">

                            <td>
                                {{ $b->judul }}
                            </td>

                            <td>
                                {{ $b->penulis }}
                            </td>

                            <td>
                                {{ $b->kategori }}
                            </td>

                            <td>
                                {{ $b->stok }}
                            </td>

                            <td class="text-center">

                                <a href="javascript:void(0)"
                                   data-id="{{ $b->id }}"
                                   class="btn btn-primary btn-sm btn-edit-b">
                                    EDIT
                                </a>

                                <a href="javascript:void(0)"
                                   data-id="{{ $b->id }}"
                                   class="btn btn-danger btn-sm btn-delete-b">
                                    DELETE
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    @include('components.modal-create')
    @include('components.modal-edit')
@endsection

@section('scripts')
        <script>
        $(document).ready(function () {

            // CREATE MODAL
            $(document).on('click', '#btn-create-b', function (e) {
                e.preventDefault();
                clearValidation();
                $('#judul,#penulis,#kategori,#deskripsi,#stok').val('');
                bootstrap.Modal.getOrCreateInstance('#modal-create').show();
            });

            // CREATE
            $(document).on('click', '#store', function (e) {
                e.preventDefault();
                clearValidation();

                let data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    judul: $('#judul').val().trim(),
                    penulis: $('#penulis').val().trim(),
                    kategori: $('#kategori').val().trim(),
                    deskripsi: $('#deskripsi').val().trim(),
                    stok: $('#stok').val()
                };

                let valid = true;

                $.each(data, function (field, value) {
                    if (field != '_token' && value === '') {
                        showError('#' + field, '#alert-' + field, field + ' wajib diisi.');
                        valid = false;
                    }
                });

                if (data.stok < 0) {
                    showError('#stok', '#alert-stok', 'Stok tidak boleh kurang dari 0.');
                    valid = false;
                }

                if (!valid) return;

                $('#store').prop('disabled', true);
                $('#store-text').text('MENYIMPAN...');
                $('#store-loading').removeClass('d-none');

                $.ajax({
                    url: "{{ route('buku.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,

                    success: function (response) {
                        let b = response.data;

                        $('#table-buku').prepend(`
                            <tr id="index_${b.id}">
                                <td>${b.judul}</td>
                                <td>${b.penulis}</td>
                                <td>${b.kategori}</td>
                                <td>${b.stok}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-id="${b.id}" class="btn btn-primary btn-sm btn-edit-b">EDIT</a>
                                    <a href="javascript:void(0)" data-id="${b.id}" class="btn btn-danger btn-sm btn-delete-b">DELETE</a>
                                </td>
                            </tr>
                        `);

                        bootstrap.Modal.getInstance(document.getElementById('modal-create'))?.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function (field, messages) {
                                showError('#' + field, '#alert-' + field, messages[0]);
                            });
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan pada server.', 'error');
                        }
                    },

                    complete: function () {
                        $('#store').prop('disabled', false);
                        $('#store-text').text('SIMPAN');
                        $('#store-loading').addClass('d-none');
                    }
                });
            });

            // AMBIL DATA EDIT
            $(document).on('click', '.btn-edit-b', function (e) {
                e.preventDefault();

                let id = $(this).data('id');

                $.get(`/buku/${id}/edit`, function (response) {
                    let b = response.data;

                    $('#edit-id').val(b.id);
                    $('#edit-judul').val(b.judul);
                    $('#edit-penulis').val(b.penulis);
                    $('#edit-kategori').val(b.kategori);
                    $('#edit-deskripsi').val(b.deskripsi);
                    $('#edit-stok').val(b.stok);

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('modal-edit')
                    ).show();
                });
            });

            // UPDATE
            $(document).on('click', '#update', function (e) {
                e.preventDefault();
                clearEditValidation();

                let id = $('#edit-id').val();

                let data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'PUT',
                    judul: $('#edit-judul').val().trim(),
                    penulis: $('#edit-penulis').val().trim(),
                    kategori: $('#edit-kategori').val().trim(),
                    deskripsi: $('#edit-deskripsi').val().trim(),
                    stok: $('#edit-stok').val()
                };

                let valid = true;

                $.each(data, function (field, value) {
                    if (!['_token', '_method'].includes(field) && value === '') {
                        showEditError(
                            '#edit-' + field,
                            '#edit-alert-' + field,
                            field + ' wajib diisi.'
                        );
                        valid = false;
                    }
                });

                if (data.stok < 0) {
                    showEditError(
                        '#edit-stok',
                        '#edit-alert-stok',
                        'Stok tidak boleh kurang dari 0.'
                    );
                    valid = false;
                }

                if (!valid) return;

                $('#update').prop('disabled', true);
                $('#update-text').text('MENGUPDATE...');
                $('#update-loading').removeClass('d-none');

                $.ajax({
                    url: `/buku/${id}`,
                    type: 'POST',
                    dataType: 'json',
                    data: data,

                    success: function (response) {
                        let b = response.data;
                        let row = $('#index_' + id);

                        row.find('td:eq(0)').text(b.judul);
                        row.find('td:eq(1)').text(b.penulis);
                        row.find('td:eq(2)').text(b.kategori);
                        row.find('td:eq(3)').text(b.stok);

                        bootstrap.Modal.getInstance(
                            document.getElementById('modal-edit')
                        )?.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function (field, messages) {
                                showEditError(
                                    '#edit-' + field,
                                    '#edit-alert-' + field,
                                    messages[0]
                                );
                            });
                        } else {
                            Swal.fire('Gagal!', 'Data gagal diupdate.', 'error');
                        }
                    },

                    complete: function () {
                        $('#update').prop('disabled', false);
                        $('#update-text').text('UPDATE');
                        $('#update-loading').addClass('d-none');
                    }
                });
            });
            
    $(document).on('click', '.btn-delete-b', function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        Swal.fire({
            title: 'Hapus buku?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YA, HAPUS',
            cancelButtonText: 'BATAL'
        }).then(function (result) {

            if (!result.isConfirmed) return;

            $.ajax({
                url: `/buku/${id}`,
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
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },

                error: function (xhr) {
                    console.log(xhr);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Data buku gagal dihapus.'
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
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            }

            function showEditError(input, alert, message) {
                $(input).addClass('is-invalid');
                $(alert).text(message);
            }

            function clearEditValidation() {
                $('#modal-edit .form-control').removeClass('is-invalid');
                $('#modal-edit .invalid-feedback').text('');
            }
        });
        </script>
@endsection