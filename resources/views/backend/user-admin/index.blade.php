@extends('layouts.backend.master')

@section('title-header')
    User Admin
@endsection

@section('menus')
    User Config
@endsection

@section('submenus')
    User Admin
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List User Admin</h5>
        </div>
        <div class="panel-body">
            
            <div class="form-group text-left">
                <a href="{{route('admin.userAdmin.create')}}" id="tambah" 
                    class="btn btn-primary">
                    <i class="icon-file-plus"></i>
                    Tambah
                </a>
            </div>
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
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
                    url: "{{route('admin.userAdmin.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "name", name: "name", orderable: false},
                    {data: "email", name: "email", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [3] },
                    { className: "text-center", "targets": [3] }
                ]
            });

            $(document).on('click', '#delete', function () {
                var id = $(this).attr('data-id');
                var image = $(this).attr('data-image');
                var disabled = $(this).attr('disabled');
                
                if (disabled) {
                    return false;   
                } else {
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
                                    url: "{{ route('admin.userAdmin.destroy') }}",
                                    method: "POST",
                                    data: {id:id, image:image},
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
                }
            })
        })
    </script>
@endsection