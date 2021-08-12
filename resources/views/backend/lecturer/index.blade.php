@extends('layouts.backend.master')

@section('title-header')
    Dosen
@endsection

@section('menus')
    Data
@endsection

@section('submenus')
    Dosen
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
            <h5 class="panel-title">List Dosen</h5>
        </div>
        <div class="panel-body">
            
            <div class="form-group text-left" style="display: inline;">
                <a href="{{route('admin.lecturer.create')}}" id="tambah" 
                    class="btn btn-primary">
                    <i class="icon-file-plus"></i>
                    Tambah
                </a>
            </div>

            <div class="form-group text-right" style="display: inline;">
                <a href="{{route('admin.export.exportLecturer')}}" class="btn btn-success">
                    <i class="icon-download"></i>
                    Download Excel
                </a>
            </div>
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>No. Registrasi</th>
                        <th>Nama Dosen</th>
                        <th>Jabatan Fungsional</th>
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
                    <h5 class="modal-title">Detail Dosen</h5>
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
                pageLength: 20,
                ajax: {
                    url: "{{route('admin.lecturer.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "no_reg", name: "no_reg"},
                    {data: "name", name: "name", orderable: false},
                    {data: "functional_position_id", name: "functional_position_id", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "15%", "targets": [1] },
                    { width: "10%", "targets": [4] },
                    { className: "text-center", "targets": [4] }
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
                                url: "{{ route('admin.lecturer.destroy') }}",
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
                url: "{{route('admin.lecturer.show')}}",
                method: "POST",
                dataType: "json",
                data: {id:id},
                success: function (data) {
                    console.log(data);
                    var data = data.data[0];
                    var jabfung;
                    var serdos;
                    var rank;

                    if (data.functional_position_id == null) {
                        jabfung = '-';
                    } else {
                        jabfung = data.functional_position.name;
                    }

                    if (data.rank == null) {
                        rank = '-';
                    } else {
                        rank = data.rank;
                    }

                    if (data.certification == false) {
                        serdos = 'Belum Tersertifikasi';
                    } else {
                        serdos = 'Sertifikasi Dosen (' + data.certification_year + ')';
                    }

                    $('#modal-detail').modal('show');
                    $('.modal-body').html(
                        `<table class="tab">
                            <img src="{{asset('storage/${data.avatar}')}}" class="img-thumbnail img-empl" onerror="this.src='{{asset('assets/admin/images/placeholder.jpg')}}'" />
                            <tr>
                                <td>No. Registrasi</td>
                                <td>:</td>
                                <td><b>${data.no_reg}</b></td>
                            </tr>
                            <tr>
                                <td>Nama Dosen</td>
                                <td>:</td>
                                <td><b>${data.name}</b></td>
                            </tr>
                            <tr>
                                <td>Jabatan Fungsional</td>
                                <td>:</td>
                                <td><b>${jabfung}</b></td>
                            </tr>
                            <tr>
                                <td>Kepangkatan</td>
                                <td>:</td>
                                <td><b>${rank}</b></td>
                            </tr>
                            <tr>
                                <td>Pendidikan Terakhir</td>
                                <td>:</td>
                                <td><b>${data.last_education}</b></td>
                            </tr>
                            <tr>
                                <td>Status Serdos</td>
                                <td>:</td>
                                <td><b>${serdos}</b></td>
                            </tr>
                            <tr>
                                <td>Penempatan</td>
                                <td>:</td>
                                <td><b>${data.major.name}</b></td>
                            </tr>
                        </table>`
                    );
                }
            })
        })

    </script>
@endsection