@extends('layouts.frontend.main')

@section('title')
    <title>Rencana Cuti</title>
@endsection

@section('content')

<link rel="stylesheet" href="{{asset('assets/plugins/powerful-calendar/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/powerful-calendar/theme.css')}}">
<style>
    html body {
        background: #FF9D34;
    }
    .sidebar .sidebar_innr .sections li.active a {
        color: #FF9D34;
    }
    #table-status-pengajuan-cuti > thead > tr {
        color: #fff;
        background-color: #FF9D34;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #FF9D34 !important;
    }
    .nav-tabs .nav-link.active:hover {
        border-bottom: 3px solid #FF9D34 !important;
    }
</style>

<div class="main_content_inner">
    
    <!-- Component Alert --> 
    @include('helper.notify')
    <!-- End Component Alert -->

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#request-leave">Rencana Cuti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#status-request-leave">Status Pengajuan Cuti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#employee-request">Pengajuan Pegawai</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div id="request-leave" class="tab-pane active">
            <div id="start-date-wrapper">
                <div class="box-wrapper">
                    <div class="box-wrapper-heading">
                        <div class="box-wrapper-heading-title">
                            Informasi Cuti {{\Carbon\Carbon::now()->format('F Y')}}
                        </div>
                    </div>
                    <div class="box-wrapper-description">
                        <div class="box-wrapper-description-title">
                            Total Sisa Kuota Cuti : <span class="badge badge-warning">{{Auth::user()->empl->leaveQuota->max_quota}}</span> Hari
                        </div>
                        <div class="box-wrapper-description-body">
                            <div class="row">
                                <div class="col-sm-6">Total Cuti/Izin Disetujui : {{$countApproval}} Hari</div>
                                <div class="col-sm-6">Total Cuti/Izin Ditolak : {{$countRejected}} Hari</div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="box-wrapper">
                    <div class="calendar-wrapper"></div>
                </div>
            
                <div class="box-wrapper">
                    <div class="box-wrapper-heading">
                        Pilih Tipe Cuti/Izin
                    </div>
                    <div class="box-wrapper-description" style="overflow: hidden;">
                        <div class="box-row">
                            <select id="type_leave" class="form-control" disabled>
                                <option value="null">Pilih Tipe</option>
                                @foreach ($typeLeave as $item)
                                    <option value="{{$item->id}}">{{$item->type_leave}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="box-row">
                            <select id="category_leave" class="form-control" disabled>
                                <option value="null">Pilih Kategori</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-right" id="btn-start-date">Submit</button>
                    </div>
                </div>
            </div>
        
            <div id="end-date-wrapper" hidden>
                <div style="font-size:24px ; color:#1c3faa; margin-bottom: 8px;">
                    <i class="fa fa-arrow-circle-left" onclick="backFormLeave();"></i>
                </div>
                <div class="box-wrapper">
                    <div class="left mb-2" style="font-size:30px;">
                        <a href="/leave" class="headerButton goBack">
                            <ion-icon name="arrow-back"></ion-icon>
                        </a>
                    </div>
                    <div class="box-wrapper-description">
                        <div class="box-row" style="overflow: hidden;">
                            <form id="form-leave">
                                {{ csrf_field() }}
                                <input type="hidden" name="type_leave" id="type_leave_val">
                                <input type="hidden" name="category_leave" id="category_leave_val">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Tanggal Mulai Cuti</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Tanggal Selesai Cuti</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 8px;">
                                    <div class="col-sm-12">
                                        <label>Keterangan</label>
                                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                    </div>
                                </div>
                               <button type="submit" class="btn btn-success btn-right" style="margin-top: 8px; color: #fff;">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="status-request-leave" class="tab-pane">
            <div class="box-wrapper">
                <div class="box-wrapper-heading">
                    <div class="box-wrapper-heading-title">
                        List data status pengajuan cuti
                    </div>
                </div>
                <div class="box-wrapper-description">
                    <table id="table-status-pengajuan-cuti" class="table table-request">
                        <thead>
                            <tr>
                                <th>ID Cuti</th>
                                <th>Detail Cuti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div id="employee-request" class="tab-pane">
            <div class="box-wrapper">
                <h1>Ini halaman pengajuan pegawai</h1>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="{{asset('assets/plugins/powerful-calendar/calendar.js')}}"></script>
<script>
    $(document).ready(function () {
        var _token = '{{ csrf_token() }}';
        var defaultConfig = {
            weekDayLength: 1,
            date: new Date(),
            onClickDate: selectDate,
            showYearDropdown: true,
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': _token
            }
        });

        // $('#type_leave').attr("disabled", true);
        // $('#category_leave').attr("disabled", true);
        $('.calendar-wrapper').calendar(defaultConfig);
        getStatusRequestLeave();
    })

    function selectDate(date) {
        var d = new Date();
        var currentDate = d.getFullYear() + "-" + (d.getMonth()+1).toString().replace(/(^.$)/,"0$1") + "-" + str_pad(d.getDate());
        var selectDate = convertDate(date);
        if (selectDate <= currentDate) {
            bootbox.alert('Tidak bisa mengajukan cuti pada Tanggal yang sudah lewat');
            return false;
        }
        $('.calendar-wrapper').updateCalendarOptions({
            date: date
        });
        $('#type_leave').attr("disabled", false);
    }

    function str_pad(n) {
        return String("00" + n).slice(-2);
    }

    function convertDate(d){
        var parts = d.split(" ");
        var months = {Jan: "01",Feb: "02",Mar: "03",Apr: "04",May: "05",Jun: "06",Jul: "07",Aug: "08",Sep: "09",Oct: "10",Nov: "11",Dec: "12"};
        return parts[3]+"-"+months[parts[1]]+"-"+parts[2];
    }

    $('#type_leave').on('change', function () {
        var typeLeaveId = $('#type_leave').find(":selected").val();
        $.ajax({
            url: "{{route('getCategoryLeave')}}",
            method: "POST",
            dataType: "json",
            data: {id: typeLeaveId},
            success: function (resp) {
                $('#category_leave option:not(:first)').remove();
                $.each(resp, function (key, item) {
                    $('#category_leave').attr("disabled", false);
                    $('#category_leave').append('<option value="'+item.id+'">'+item.category_leave+'</option>');
                })
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log(err.message);
            }
        })
    })

    $('#btn-start-date').on('click', function (e) {
        e.preventDefault();
        loadingproses();

        var typeLeave = $('#type_leave').find(":selected").val();
        var categoryLeave = $('#category_leave').find(":selected").val();
        var clickDate = $('.week').find('.selected').attr('data-date');
        var startDate = convertDate(clickDate);
        
        if (typeLeave == "null" || categoryLeave == "null") {
            bootbox.alert('Pilih kategori cuti/izin');
            loadingproses_close();
            return false;
        }
        $.ajax({
            url: "{{route('getLeave')}}",
            method: "POST",
            dataType: "json",
            data: {
                type_leave: typeLeave,
                category_leave: categoryLeave,
                start_date: startDate
            },
            success: function (resp) {
                console.log(resp)
                $('#start-date-wrapper').hide();
                $('#end-date-wrapper').attr("hidden", false);
                $('#type_leave_val').val(typeLeave);
                $('#category_leave_val').val(categoryLeave);
                $('#start_date').val(startDate);
                loadingproses_close();
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log(err.message);
                loadingproses_close();
            }
        })
    })

    $(document).on("change", "#end_date" , function() {
        var startDate = $('#start_date').val();
        var endDate = $(this).val();
        if (endDate < startDate) {
            bootbox.alert('Tidak bisa memilih Tanggal selesai cuti sebelum Tanggal mulai cuti');
            $('#end_date').val('');
        }
        return true;
    });

    $(document).on("submit", "#form-leave", function (e) {
        e.preventDefault();
        loadingproses();

        var endDate = $('#end_date').val();
        
        if (endDate == "") {
            bootbox.alert('Tentukan Tanggal akhir cuti');
            loadingproses_close();
            return false;
        }

        $.ajax({
            url: "{{route('postLeave')}}",
            method: "POST",
            dataType: "json",
            data: $('#form-leave').serialize(),
            success: function (data) {
                console.log(data);
                $('.alert-danger').attr("hidden", true);
                $('.alert-success').attr("hidden", false);
                $('.alert-success strong').text(data.message);
                $('#description').val('');
                $('#end_date').val('');
                $('#table-status-pengajuan-cuti').DataTable().ajax.reload();
                loadingproses_close();
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log(err.message);
                $('.alert-success').attr("hidden", true);
                $('.alert-danger').attr("hidden", false);
                $('.alert-danger strong').text(err.message);
                $('#description').val('');
                $('#end_date').val('');
                loadingproses_close();
            }
        })
    })

    function backFormLeave() {
        window.location.href="{{route('leave')}}";
    }

    function getStatusRequestLeave() {
        $('#table-status-pengajuan-cuti').DataTable({
            processing: true,
            serverside: true,
            autoWidth: false,
            bLengthChange: false,
            pageLength: 10,
            ajax: {
                url: "{{route('getStatusRequestLeave')}}",
                type: "POST",
            },
            order: [[ 0, "desc" ]],
            columns: [
                {data: "tr_leave_id", name: "tr_leave_id"},
                {data: "detail_leave", name: "detail_leave", orderable: false},
                {
                    data: "status", 
                    name: "status",
                    render: function (data, type, full, meta) {
                        return badgeStatus(data);
                    },
                    orderable: false
                },
                {data: "action", name: "action", orderable: false}
            ],
            columnDefs: [
                { width: "20%", "targets": [0] },
                { width: "60%", "targets": [1] },
                { width: "10%", "targets": [2, 3] },
                { className: "text-center", "targets": [2, 3] }
            ]
        });
    }

    function badgeStatus(status) {    
        if (status == 1) {
            return '<span class="text-warning">Pending</span>';
        } else if (status == 2) {
            return '<span class="text-success">Approve</span>';
        } else if (status == 3) {
            return '<span class="text-secondary">Cancelled</span>';
        } else {
            return '<span class="text-danger">Reject</span>';
        }
    }

    $(document).on('click', '.cancel-request', function () {
        var id = $(this).attr('data-id');
        bootbox.confirm("Apakah anda yakin akan membatalkan pengajuan ini?", function (result) {
            if (result) {
                $.ajax({
                    url: "{{route('cancelRequestLeave')}}",
                    method: "POST",
                    data: {id:id},
                    success: function (resp) {
                        bootbox.alert("Pengajuan cuti berhasil dibatalkan");
                        $('#table-status-pengajuan-cuti').DataTable().ajax.reload();
                    },
                    error: function (resp) {
                        var res = resp.responseJSON;
                        bootbox.alert(res.message);
                    }
                })
            }
        })
    })
</script>
@endsection