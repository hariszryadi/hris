@extends('layouts.frontend.main')

@section('title')
    <title>Rencana Lembur</title>
@endsection

@section('content')

<link rel="stylesheet" href="{{asset('assets/plugins/powerful-calendar/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/powerful-calendar/theme.css')}}">
<style>
    html body {
        background: #1b9d41;
    }
    .sidebar .sidebar_innr .sections li.active a {
        color: #1b9d41;
    }
    @media (max-width: 1260px) {
        .mobile-visible .main_sidebar {
            background: #1b9d41;
        }
    }
    #table-status-pengajuan-lembur > thead > tr, #table-pengajuan-lembur-pegawai > thead > tr {
        color: #fff;
        background-color: #1b9d41;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #1b9d41 !important;
    }
    .nav-tabs .nav-link.active:hover {
        border-bottom: 3px solid #1b9d41 !important;
    }
</style>

<div class="main_content_inner">
    
    <!-- Component Alert --> 
    @include('helper.notify')
    <!-- End Component Alert -->

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#request-overtime">Rencana Lembur</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#status-request-overtime">Status Pengajuan Lembur</a>
        </li>
        @if (Auth::user()->empl->head_division == true)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#employee-request">Pengajuan Pegawai</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        <div id="request-overtime" class="tab-pane active">
            <div id="start-date-wrapper">
                <div class="box-wrapper">
                    <div class="box-wrapper-heading">
                        <div class="box-wrapper-heading-title">
                            Informasi Lembur {{\Carbon\Carbon::now()->format('F Y')}}
                        </div>
                    </div>
                    <div class="box-wrapper-description">
                        <div class="box-wrapper-description-title">
                            Total Jam Lembur : <span class="badge badge-warning">{{ $countOvertime }}</span> Jam
                        </div>
                        {{-- <div class="box-wrapper-description-body">
                            <div class="row">
                                <div class="col-sm-6">Total Lembur Disetujui : 0</div>
                                <div class="col-sm-6">Total Lembur Ditolak : 0</div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            
                <div class="box-wrapper">
                    <div class="calendar-wrapper"></div>
                </div>
            
                <div class="box-wrapper">
                    {{-- <div class="box-wrapper-heading">
                        Atur Waktu Lembur
                    </div> --}}
                    <div class="box-wrapper-description" style="overflow: hidden;">
                        <form id="form-overtime">
                            <input type="hidden" name="overtime_date" id="overtime_date">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Waktu Mulai</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time" value="17:00">
                                </div>
                                <div class="col-sm-4">
                                    <label>Waktu Akhir</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time" value="18:00">
                                </div>
                                <div class="col-sm-4">
                                    <label>Durasi</label>
                                    <input type="time" class="form-control" name="duration" id="duration" value="01:00" readonly>
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

        <div id="status-request-overtime" class="tab-pane">
            <div class="box-wrapper">
                <div class="box-wrapper-heading">
                    <div class="box-wrapper-heading-title">
                        List data status pengajuan lembur
                    </div>
                </div>
                <div class="box-wrapper-description">
                    <table id="table-status-pengajuan-lembur" class="table table-responsive-lg table-request">
                        <thead>
                            <tr>
                                <th>ID Lembur</th>
                                <th>Detail Lembur</th>
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
                <div class="box-wrapper-heading">
                    <div class="box-wrapper-heading-title">
                        List data pengajuan lembur pegawai
                    </div>
                </div>
                <div class="box-wrapper-description">
                    <table id="table-pengajuan-lembur-pegawai" class="table table-responsive-lg table-request">
                        <thead>
                            <tr>
                                <th>ID Lembur</th>
                                <th>Detail Lembur</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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

        $('.calendar-wrapper').calendar(defaultConfig);
        getStatusRequestOvertime();
        getEmplRequestOvertime();
    })

    function selectDate(date) {
        var d = new Date();
        var currentDate = d.getFullYear() + "-" + (d.getMonth()+1).toString().replace(/(^.$)/,"0$1") + "-" + str_pad(d.getDate());
        var selectDate = convertDate(date);
        if (selectDate < currentDate) {
            bootbox.alert('Tidak bisa mengajukan lembur pada Tanggal yang sudah lewat');
            return false;
        }
        $('.calendar-wrapper').updateCalendarOptions({
            date: date
        });
        $('#overtime_date').val(selectDate);
    }

    function str_pad(n) {
        return String("00" + n).slice(-2);
    }

    function convertDate(d){
        var parts = d.split(" ");
        var months = {Jan: "01",Feb: "02",Mar: "03",Apr: "04",May: "05",Jun: "06",Jul: "07",Aug: "08",Sep: "09",Oct: "10",Nov: "11",Dec: "12"};
        return parts[3]+"-"+months[parts[1]]+"-"+parts[2];
    }

    $('#start_time, #end_time').on('change', function () {
        var startTime = $('#start_time').val();
        var endTime = $('#end_time').val();
        loadingproses();

        if (startTime < "17:00" || endTime < "17:00") {
            bootbox.alert('Tidak bisa mengajukan lembur dibawah pukul 17:00');
            loadingproses_close();
            $('#start_time').val("17:00");
            $('#end_time').val("18:00");
            $('#duration').val("01:00");
            return false;
        }

        $.ajax({
            type: 'GET',
            success: function (data) {
                getDuration(startTime, endTime);
                loadingproses_close();
            }
        })
    })

    $('#form-overtime').on('submit', function (e) {
        e.preventDefault();
        loadingproses();

        $.ajax({
            url: "{{route('postOvertime')}}",
            type: "POST",
            dataType: "json",
            data: $('#form-overtime').serialize(),
            success: function (data) {
                console.log(data);
                $('.alert-danger').attr("hidden", true);
                $('.alert-success').attr("hidden", false);
                $('.alert-success strong').text(data.message);
                $('#description').val('');
                $('#start_time').val("17:00");
                $('#end_time').val("18:00");
                $('#duration').val("01:00");
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                $('#table-status-pengajuan-lembur').DataTable().ajax.reload();
                $('#table-pengajuan-lembur-pegawai').DataTable().ajax.reload();
                loadingproses_close();
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log(err.message);
                $('.alert-success').attr("hidden", true);
                $('.alert-danger').attr("hidden", false);
                $('.alert-danger strong').text(err.message);
                $('#description').val('');
                $('#start_time').val("17:00");
                $('#end_time').val("18:00");
                $('#duration').val("01:00");
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                loadingproses_close();
            }
        })
    })

    function getDuration(startTime, endTime) {
        var str0="01/01/1970 " + startTime;
        var str1="01/01/1970 " + endTime;
        var diff=(Date.parse(str1)-Date.parse(str0))/1000/60;
        var hours=String(100+Math.floor(diff/60)).substr(1);
        var mins=String(100+diff%60).substr(1);

        $('#duration').val((hours+':'+mins));
    }

    function getStatusRequestOvertime() {
        $('#table-status-pengajuan-lembur').DataTable({
            processing: true,
            serverside: true,
            autoWidth: false,
            bLengthChange: false,
            pageLength: 10,
            ajax: {
                url: "{{route('getStatusRequestOvertime')}}",
                type: "POST",
            },
            order: [[ 0, "desc" ]],
            columns: [
                {data: "tr_overtime_id", name: "tr_overtime_id"},
                {data: "detail_overtime", name: "detail_overtime", orderable: false},
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

    function getEmplRequestOvertime() {
        $('#table-pengajuan-lembur-pegawai').DataTable({
            processing: true,
            serverside: true,
            autoWidth: false,
            bLengthChange: false,
            pageLength: 10,
            ajax: {
                url: "{{route('getEmplRequestOvertime')}}",
                type: "POST",
            },
            order: [[ 0, "desc" ]],
            columns: [
                {data: "tr_overtime_id", name: "tr_overtime_id"},
                {data: "detail_overtime", name: "detail_overtime", orderable: false},
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
                { width: "15%", "targets": [0] },
                { width: "65%", "targets": [1] },
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

    $(document).on('click', '.update-status', function () {
        var overtimeId = $(this).attr('data-overtime-id');
        var status = $(this).attr('data-status');
        var action = $(this).text();
        bootbox.confirm("Apakah anda yakin akan "+action+" pengajuan ini?", function (result) {
            if (result) {
                $.ajax({
                    url: "{{route('updateStatusRequestOvertime')}}",
                    method: "POST",
                    data: {overtimeId:overtimeId, status:status},
                    success: function (resp) {
                        bootbox.alert('Pengajuan lembur berhasil di '+action);
                        $('#table-status-pengajuan-lembur').DataTable().ajax.reload();
                        $('#table-pengajuan-lembur-pegawai').DataTable().ajax.reload();
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