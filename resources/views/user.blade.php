@extends('layouts.app')

@section('title', 'User')

@section('content')
    <div class="card overflow-auto">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data User</h5>
                <a href="javascript:void(0)" class="btn btn-success" id="btn-create-u">TAMBAH</a>
            </div>

            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="table-user">
                    @foreach($user as $u)
                        <tr id="index_{{ $u->id }}">
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $u->id }}"
                                   class="btn btn-primary btn-sm btn-edit-u">EDIT</a>
                                <a href="javascript:void(0)" data-id="{{ $u->id }}"
                                   class="btn btn-danger btn-sm btn-delete-u">DELETE</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('components.modal-user')
@endsection

@section('scripts')
    <script>
    $(document).ready(function () {

        // CREATE
        $(document).on('click', '#btn-create-u', function () {
            clearValidation();
            $('#user-id,#name,#email,#password,#role').val('');
            $('#password').attr('placeholder', 'Password');
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('modal-user')
            ).show();
        });

        // SAVE
        $(document).on('click', '#save-user', function (e) {
            e.preventDefault();
            clearValidation();

            let id = $('#user-id').val();
            let data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#name').val().trim(),
                email: $('#email').val().trim(),
                password: $('#password').val(),
                role: $('#role').val()
            };

            let url = id ? `/user/${id}` : "{{ route('user.store') }}";
            let type = id ? 'POST' : 'POST';

            if (id) data._method = 'PUT';

            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function (response) {
                    let u = response.data;

                    if (id) {
                        let row = $('#index_' + id);
                        row.find('td:eq(0)').text(u.name);
                        row.find('td:eq(1)').text(u.email);
                        row.find('td:eq(2)').text(u.role);
                    } else {
                        $('#table-user').prepend(`
                            <tr id="index_${u.id}">
                                <td>${u.name}</td>
                                <td>${u.email}</td>
                                <td>${u.role}</td>
                                <td>
                                    <a href="javascript:void(0)" data-id="${u.id}" class="btn btn-primary btn-sm btn-edit-u">EDIT</a>
                                    <a href="javascript:void(0)" data-id="${u.id}" class="btn btn-danger btn-sm btn-delete-u">DELETE</a>
                                </td>
                            </tr>
                        `);
                    }

                    bootstrap.Modal.getInstance(
                        document.getElementById('modal-user')
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
                            showError('#' + field, '#alert-' + field, messages[0]);
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    }
                }
            });
        });

        // EDIT
        $(document).on('click', '.btn-edit-u', function () {
            let id = $(this).data('id');

            $.get(`/user/${id}/edit`, function (response) {
                let u = response.data;

                $('#user-id').val(u.id);
                $('#name').val(u.name);
                $('#email').val(u.email);
                $('#password').val('');
                $('#password').attr('placeholder', 'Kosongkan jika tidak diubah');
                $('#role').val(u.role);

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('modal-user')
                ).show();
            });
        });

        // DELETE
        $(document).on('click', '.btn-delete-u', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Hapus user?',
                text: 'Data tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'YA, HAPUS',
                cancelButtonText: 'BATAL'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: `/user/${id}`,
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
    });
    </script>
@endsection
