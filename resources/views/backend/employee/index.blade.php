@extends('layouts.backend.master')

@section('title-header')
    Pegawai
@endsection

@section('menus')
    Master
@endsection

@section('submenus')
    Pegawai
@endsection

@section('content')
    <style>
        .img-empl {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List Pegawai</h5>
        </div>
        <div class="panel-body">
            
            @if (auth()->user()->roles()->first()->permission_role()->byId(2)->first()->create_right == true)
                <div class="form-group text-left">
                    <a href="{{route('admin.employee.create')}}" id="tambah" 
                        class="btn btn-primary">
                        <i class="icon-file-plus"></i>
                        Tambah
                    </a>
                </div>       
            @endif
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Email</th>
                        <th>Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal detail -->
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var _token = '{{ csrf_token() }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });

            $('.datatable-basic').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                bLengthChange: false,
                pageLength: 10,
                ajax: {
                    url: "{{route('admin.employee.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "nip", name: "nip"},
                    {data: "empl_name", name: "empl_name", orderable: false},
                    {data: "email", name: "email", orderable: false},
                    {data: "division_id", name: "division_id", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [5] },
                    { className: "text-center", "targets": [5] }
                ]
            });

            $(document).on('click', '#delete', function () {
                var id = $(this).attr('data-id');
                var avatar = $(this).attr('data-avatar');
                swal({
                    title: "Apakah Anda Yakin Akan Menghapus Data ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Kembali",
                    closeOnConfirm: false,
                    closeOnCancel: true
                    }, function(result) {
                        if (result) {
                            $.ajax({
                                url: "{{ route('admin.employee.destroy') }}",
                                method: "POST",
                                data: {id:id, avatar:avatar},
                                success: function (resp) {
                                    $('.datatable-basic').DataTable().ajax.reload();
                                    swal('Sukses!', resp.message, 'success');
                                },
                                error: function (resp) {
                                    swal('Error!', resp.message, 'error');
                                }
                            })
                        }
                    }
                )
            })
        })

        $(document).on('click', '#show', function () {
            var id = $(this).attr('data-id');
            
            $.ajax({
                url: "{{route('admin.employee.show')}}",
                method: "POST",
                dataType: "json",
                data: {id:id},
                success: function (data) {
                    console.log(data);
                    var data = data.data[0];
                    var error;
                    if (data.gender == 'Pria') {
                        error = "this.src='{{asset('assets/admin/images/male.png')}}'";
                    } else {
                        error = "this.src='{{asset('assets/admin/images/female.png')}}'";
                    }
                    $('#modal-detail').modal('show');
                    $('.modal-body').html(
                        `<table class="tab">
                            <img src="{{asset('storage/${data.avatar}')}}" class="img-thumbnail img-empl" onerror=${error} />
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><b>${data.empl_name}</b></td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td>:</td>
                                <td><b>${data.nip}</b></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><b>${formatDate(data.birth_date)}</b></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><b>${data.address}</b></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><b>${data.email}</b></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><b>${data.gender}</b></td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>:</td>
                                <td><b>${data.religion}</b></td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td>:</td>
                                <td><b>${data.division.name}</b></td>
                            </tr>
                        </table>`
                    );
                }
            })
        })

        function formatDate(date) {
            var parts = date.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }
    </script>
@endsection