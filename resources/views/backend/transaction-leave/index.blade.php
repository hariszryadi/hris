@extends('layouts.backend.master')

@section('title-header')
    Transaksi Cuti/Izin
@endsection

@section('menus')
    Transaction
@endsection

@section('submenus')
    Transaksi Cuti/Izin
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">List Transaksi Cuti/Izin</h5>
        </div>
        <div class="panel-body">
            
            {{-- <div class="form-group text-left">
                <a href="{{route('admin.categoryLeave.create')}}" id="tambah" 
                    class="btn btn-primary">
                    <i class="icon-file-plus"></i>
                    Tambah
                </a>
            </div> --}}
            
            <table class="table datatable-basic table-hover table-bordered striped">
                <thead>
                    <tr class="bg-teal-400">
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>ID Transaksi Cuti/Izin</th>
                        <th>Tanggal Mulai Cuti</th>
                        <th>Tanggal Selesai Cuti</th>
                        <th>Kategori Cuti/Izin</th>
                        <th>Keterangan</th>
                        <th>Status</th>
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
                    url: "{{route('admin.transactionLeave.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "empl_id", name: "empl_id", orderable: false},
                    {data: "tr_leave_id", name: "tr_leave_id", orderable: false},
                    {data: "start_date", name: "start_date", orderable: false},
                    {data: "end_date", name: "end_date", orderable: false},
                    {data: "category_leave_id", name: "category_leave_id", orderable: false},
                    {data: "description", name: "description", orderable: false},
                    {data: "status", name: "status", orderable: false},
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [3, 4, 7] },
                    { width: "20%", "targets": [6] },
                    { className: "text-center", "targets": [3, 4, 7] }
                ]
            });
        })
    </script>
@endsection