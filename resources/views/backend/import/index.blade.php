@extends('layouts.backend.master')

@section('title-header')
    Import
@endsection

@section('menus')
    Import
@endsection

@section('submenus')
    Import Absensi
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List Import Absensi</h5>
        </div>
        <div class="panel-body">
            
            <div class="form-group text-left">
                <button id="import-absensi" class="btn btn-success"><i class="icon-file-plus"></i>
                    Import Absensi
                </button>
            </div>       
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>Tanggal Import</th>
                        <th>User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Import Excel -->
    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="/siswa/import_excel" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label>Pilih file excel</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                            <input type="file" class="form-control" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
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

        })

        $('#import-absensi').on('click', function () {
            $('#modal-import').modal('show');
        })

        $('#form-import').on('submit', function (e) {
            e.preventDefault();

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
                    swal('Sukses!', resp.success, 'success');
                },
                error: function (err) {
                    var errors = err.responseJSON;
                    $('#modal-import').modal('hide');
                    swal('Error!', errors.error, 'error');
                }
            })            
        })
    </script>
    
@endsection