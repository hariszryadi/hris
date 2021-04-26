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
</style>

<div class="main_content_inner">
    
    <!-- Component Alert --> 
    @include('helper.notify')
    <!-- End Component Alert -->

    <div id="start-date-wrapper">
        <div class="box-wrapper">
            <div class="box-wrapper-heading">
                <div class="box-wrapper-heading-title">
                    Informasi Lembur {{\Carbon\Carbon::now()->format('F Y')}}
                </div>
            </div>
            <div class="box-wrapper-description">
                <div class="box-wrapper-description-title">
                    Total Jam Lembur : <span class="badge badge-warning">0</span> Jam
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
        // $('#type_leave').attr("disabled", false);
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
</script>  
@endsection