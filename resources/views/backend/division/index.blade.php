@extends('layouts.backend.master')

@section('title-header')
    Divisi
@endsection

@section('menus')
    Master
@endsection

@section('submenus')
    Divisi
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List Divisi</h5>
        </div>
        <div class="panel-body">
            
            <div class="form-group text-left">
                <a href="{{route('admin.division.create')}}" id="tambah" 
                    class="btn btn-primary">
                    <i class="icon-file-plus"></i>
                    Tambah
                </a>
            </div>       
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>Nama Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

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
                    url: "{{route('admin.division.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "name", name: "name", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [2] },
                    { className: "text-center", "targets": [2] }
                ]
            });

            $(document).on('click', '#delete', function () {
                var id = $(this).attr('data-id');
                bootbox.confirm("Apakah anda yakin akan menghapus data ini?", function(result) {
                    if (result) {
                        $.ajax({
                            url: "{{ route('admin.division.destroy') }}",
                            method: "POST",
                            data: {id:id},
                            success: function (resp) {
                                bootbox.alert("Hapus Data Berhasil");
                                $('.datatable-basic').DataTable().ajax.reload();
                            },
                            error: function (resp) {
                                var res = resp.responseJSON;
                                bootbox.alert(res.message);
                            }
                        })
                    }
                }); 
            })
        })
    </script>
@endsection