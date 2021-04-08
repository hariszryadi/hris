@extends('layouts.frontend.master')

@section('title')
    <title>Rencana Cuti</title>
@endsection

@section('pageTitle')
    Rencana Cuti
@endsection

@section('content')
    <link rel="stylesheet" href="{{asset('assets/plugins/powerful-calendar/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/powerful-calendar/theme.css')}}">
    
    <div class="appCapsule">
        <div class="section mt-2">
            <!-- Component Alert --> 
            @include('helper.component-alert')
            <!-- End Component Alert -->
            <div class="section-leave-quota">
                <div class="section-leave-quota-title">
                    Informasi Cuti {{\Carbon\Carbon::now()->format('F Y')}}
                </div>
                <div class="section-leave-quota-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            Total Sisa Kuota Cuti : <span class="badge badge-warning">{{Auth::user()->empl->leaveQuota->max_quota}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Total Cuti Disetujui : 0
                        </div>
                        <div class="col-6">
                            Total Izin Disetujui : 0
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2">
            <div class="container">
                <div class="calendar-wrapper"></div>
            </div>
        </div>
        <div class="section mt-2">
            <div class="section-leave-form">
                <div class="section-leave-form-type">
                    <div class="section-leave-form-type-label">Pilih Tipe Cuti/Izin</div>
                    <form id="form-start-date">
                        {{ csrf_field() }}
                        <div class="leave-form-type">
                            <select name="type_leave" id="type_leave" class="form-control">
                                <option value="null">Pilih Tipe</option>
                                @foreach ($typeLeave as $item)
                                    <option value="{{$item->id}}">{{$item->type_leave}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="leave-form-category">
                            <select name="category_leave" id="category_leave" class="form-control">
                                <option value="null">Pilih Kategori</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/plugins/powerful-calendar/calendar.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script>
        $(document).ready(function () {
            var _token = '{{ csrf_token() }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });

            $('#type_leave').attr("disabled", true);
            $('#category_leave').attr("disabled", true);
        })

        function selectDate(date) {
            var d = new Date();
            var currentDate = d.getFullYear() + "-" + (d.getMonth()+1).toString().replace(/(^.$)/,"0$1") + "-" + d.getDate();
            var selectDate = convertDate(date);
            if (selectDate <= currentDate) {
                bootbox.alert('Tidak Bisa Mengajukan Cuti Pada Tanggal Yang Sudah Lewat');
                return false;
            }
            $('.calendar-wrapper').updateCalendarOptions({
                date: date
            });
            $('#type_leave').attr("disabled", false);
        }

        var defaultConfig = {
            weekDayLength: 1,
            date: new Date(),
            onClickDate: selectDate,
            showYearDropdown: true,
        };

        $('.calendar-wrapper').calendar(defaultConfig);

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
                    console.log(err.Message);
                }
            })
        })

        function convertDate(d){
            var parts = d.split(" ");
            var months = {Jan: "01",Feb: "02",Mar: "03",Apr: "04",May: "05",Jun: "06",Jul: "07",Aug: "08",Sep: "09",Oct: "10",Nov: "11",Dec: "12"};
            return parts[3]+"-"+months[parts[1]]+"-"+parts[2];
        }

        $('#form-start-date').on('submit', function (e) {
            e.preventDefault();
            var typeLeave = $('#type_leave').find(":selected").val();
            var categoryLeave = $('#category_leave').find(":selected").val();
            var clickDate = $('.week').find('.selected').attr('data-date');
            var startDate = convertDate(clickDate);
            
            if (typeLeave == "null" || categoryLeave == "null") {
                bootbox.alert('Pilih Kategori Cuti/Izin');
                return false;
            }
            $.ajax({
                url: "{{route('submitStartDateLeave')}}",
                method: "POST",
                dataType: "json",
                data: {
                    type_leave: typeLeave,
                    category_leave: categoryLeave,
                    start_date: startDate
                },
                success: function (resp) {
                    console.log(resp)
                    $('.appCapsule').empty();
                    $('.appCapsule').html(
                        '<div class="section mt-2">'
                        +   '<div class="left mb-2" style="font-size:30px;">'
                        +       '<a href="/leave" class="headerButton goBack">'
                        +           '<ion-icon name="arrow-back"></ion-icon>'
                        +       '</a>'
                        +   '</div>'
                        +   '<div class="section-leave-form">'
                        +       '<div class="section-leave-form-type">'
                        +           '<form method="post" action="/submitEndDateLeave" id="form-end-date">'
                        +               '{{ csrf_field() }}'
                        +               '<div class="row">'
                        +                   '<div class="col-md-6 col-xs-12 mb-2">'
                        +                       '<div class="section-leave-form-type-label">'
                        +                           'Tanggal Mulai Cuti'
                        +                       '</div>'
                        +                       '<input type="date" class="form-control" name="start_date" id="start_date" value="'+startDate+'" readonly>'
                        +                   '</div>'
                        +                   '<div class="col-md-6 col-xs-12 mb-2">'
                        +                       '<div class="section-leave-form-type-label">'
                        +                           'Tanggal Selesai Cuti'
                        +                       '</div>'
                        +                       '<input type="date" class="form-control" name="end_date" id="end_date">'
                        +                   '</div>'
                        +                   '<div class="col-md-6 col-xs-12 mb-2">'
                        +                       '<div class="section-leave-form-type-label">'
                        +                           'Keterangan'
                        +                       '</div>'
                        +                       '<textarea class="form-control" name="description" id="description" rows="3"></textarea>'
                        +                   '</div>'
                        +               '</div>'
                        +               '<input type="hidden" name="type_leave" value="'+typeLeave+'">'
                        +               '<input type="hidden" name="category_leave" value="'+categoryLeave+'">'
                        +               '<button type="submit" class="btn btn-warning btn-right">Submit</button>'
                        +           '</form>'
                        +       '</div>'
                        +   '</div>'
                    )
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    console.log(err.Message);
                }
            })
        })

        $(document).on("change", "#end_date" , function() {
            var startDate = $('#start_date').val();
            var endDate = $(this).val();
            if (endDate < startDate) {
                bootbox.alert('Tidak Bisa Memilih Tanggal Selesai Cuti Sebelum Tanggal Mulai Cuti');
                $('#end_date').val('');
            }
            return true;
        });

        $(document).on("submit", "#form-end-date", function () {
            var endDate = $('#end_date').val();
            if (endDate == "") {
                bootbox.alert('Tentukan Tanggal Akhir Cuti');
                return false;
            }
            return true;
        })

    </script>
@endsection