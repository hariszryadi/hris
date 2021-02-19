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
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List Pegawai</h5>
        </div>
        <div class="panel-body">
            
            <div class="form-group text-left">
                <a href="{{route('admin.employee.create')}}" id="tambah" 
                    class="btn btn-primary">
                    <i class="icon-file-plus"></i>
                    Tambah
                </a>
            </div>       
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>NIP Pegawai</th>
                        <th>Nama Pegawai</th>
                        <th>Divisi Pegawai</th>
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
                    url: "{{route('admin.employee.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "nip", name: "nip", orderable: false},
                    {data: "empl_name", name: "empl_name", orderable: false},
                    {data: "division_id", name: "division_id", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [4] },
                    { className: "text-center", "targets": [4] }
                ]
            });

            $(document).on('click', '#delete', function () {
                var id = $(this).attr('data-id');
                bootbox.confirm("Apakah anda yakin akan menghapus data ini?", function(result) {
                    if (result) {
                        $.ajax({
                            url: "{{ route('admin.employee.destroy') }}",
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