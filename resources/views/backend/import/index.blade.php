@extends('layouts.backend.master')

@section('title-header')
    Import Absensi
@endsection

@section('menus')
    Import
@endsection

@section('submenus')
    Import Absensi
@endsection

@section('content')
    <style>
        .form-text {
            display: block;
            margin-top: .5rem;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List Import Absensi</h5>
        </div>
        <div class="panel-body">
            
            @if (auth()->user()->roles()->first()->permission_role()->byId(6)->first()->create_right == true)
                <div class="form-group text-left">
                    <button id="import-absensi" class="btn btn-success"><i class="icon-file-plus"></i>
                        Import Absensi
                    </button>
                </div>       
            @endif
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>Tanggal Import</th>
                        <th>User Import</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Import Excel -->
    <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-import" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-import-title">Import Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Pilih file excel</label>
                        <div class="form-group">
                            <input type="file" class="form-control" name="file" id="file">
                            <span class="form-text text-muted">*Import absensi dilakukan 1 kali setiap bulannya</span>
                        </div>
                    </div>
                    <div class="modal-footer footer-button">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                    <div class="modal-footer footer-loading" style="display: none;">
                        <p class="text-right">Loading..</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var table;
        var _token

        $(document).ready(function () {
            _token = '{{ csrf_token() }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });

            table = $('.datatable-basic').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                bLengthChange: false,
                bFilter: false,
                pageLength: 10,
                ajax: {
                    url: "{{route('admin.import.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    // {data: "empl_name", name: "empl_name", orderable: false},
                    // {data: "created_at", name: "created_at", orderable: false},
                    {data: "date", name: "date", orderable: false},
                    {data: "user", name: "user", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [3] },
                    { className: "text-center", "targets": [3] }
                ]
            });

        })

        $('#import-absensi').on('click', function () {
            $('#modal-import').modal('show');
        })

        $('.close, .btn-secondary').on('click', function () {
            $('#file').val('');
        })

        $('#form-import').on('submit', function (e) {
            e.preventDefault();
            $('.footer-button').hide();
            $('.footer-loading').show();

            $.ajax({
                url: "{{route('admin.import.absencye')}}",
                type: "POST",
                contentType: false,
                processData: false,
                data: new FormData($('#form-import')[0]),
                success: function (resp) {
                    // var response = resp.responseJSON;
                    console.log(resp.success);
                    $('#modal-import').modal('hide');
                    $('.footer-button').show();
                    $('.footer-loading').hide();
                    table.ajax.reload();
                    $('#file').val('');
                    swal('Sukses!', resp.success, 'success');
                },
                error: function (err) {
                    var errors = err.responseJSON;
                    $('#modal-import').modal('hide');
                    $('.footer-button').show();
                    $('.footer-loading').hide();
                    $('#file').val('');
                    swal('Error!', errors.message, 'error');
                }
            })            
        })

        $(document).on('click', '#delete', function () {
            var created_at = $(this).attr('data-date');
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
                            url: "{{ route('admin.import.destroy') }}",
                            method: "POST",
                            data: {created_at:created_at},
                            success: function (resp) {
                                table.ajax.reload();
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
    </script>
    
@endsection