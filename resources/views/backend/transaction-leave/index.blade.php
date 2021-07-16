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
                        <th>Status</th>
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
                    <h5 class="modal-title" id="modal-detail-title"></h5>
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
                    url: "{{route('admin.transactionLeave.index')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "empl_id", name: "empl_id", orderable: false},
                    {data: "tr_leave_id", name: "tr_leave_id", orderable: false},
                    {
                        data: "start_date", 
                        name: "start_date", 
                        render: function (data, type, full, meta) {
                            return formatDate(data);
                        },
                        orderable: false
                    },
                    {
                        data: "end_date", 
                        name: "end_date",
                        render: function (data, type, full, meta) {
                            return formatDate(data);
                        },
                        orderable: false
                    },
                    {data: "category_leave_id", name: "category_leave_id", orderable: false},
                    {
                        data: "status", 
                        name: "status",
                        render: function (data, type, full, meta) {
                            return badgeStatus(data);
                        },
                        orderable: false
                    },
                    {data: "action", name: "action", orderable: false},
                ],
                columnDefs: [
                    { width: "5%", "targets": [0] },
                    { width: "10%", "targets": [3, 4, 5, 6, 7] },
                    { className: "text-center", "targets": [3, 4, 5, 6, 7] }
                ]
            });
        })

        function formatDate(date) {
            var parts = date.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

        function badgeStatus(status) {    
            if (status == 1) {
                return '<span class="badge bg-orange">Pending</span>';
            } else if (status == 2) {
                return '<span class="badge bg-success">Approve</span>';
            } else if (status == 3) {
                return '<span class="badge bg-grey">Cancelled</span>';
            } else {
                return '<span class="badge bg-danger">Reject</span>';
            }
        }

        $(document).on('click', '#show', function () {
            var id = $(this).attr('data-id');
            
            $.ajax({
                url: "{{route('admin.transactionLeave.show')}}",
                method: "POST",
                dataType: "json",
                data: {id:id},
                success: function (data) {
                    console.log(data);
                    var data = data.data[0];
                    $('#modal-detail').modal('show');
                    $('#modal-detail-title').text(data.tr_leave_id);
                    $('.modal-body').html(
                        `<table class="tab">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><b>${data.empl.empl_name}</b></td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td>:</td>
                                <td><b>${data.empl.nip}</b></td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td>:</td>
                                <td><b>${data.empl.division.name}</b></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Tanggal Mulai Cuti/Izin</td>
                                <td>:</td>
                                <td>${formatDate(data.start_date)}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai Cuti/Izin</td>
                                <td>:</td>
                                <td>${formatDate(data.end_date)}</td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>${data.type_leave.type_leave}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>:</td>
                                <td>${data.category_leave.category_leave}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>${badgeStatus(data.status)}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td>${data.description}</td>
                            </tr>
                        </table>`
                    );
                }
            })
        })
    </script>
@endsection