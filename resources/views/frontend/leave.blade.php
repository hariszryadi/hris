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
            <div class="section-leave-quota">
                <div class="section-leave-quota-title">
                    Total Sisa Kuota Cuti
                </div>
                <div class="section-leave-quota-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            Total Sisa Kuota Cuti : <span>12</span>
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
                    <form id="form-leave">
                        {{ csrf_field() }}
                        <div class="leave-form-type">
                            <select name="type_leave" id="type_leave" class="form-control">
                                <option>Pilih Tipe</option>
                                @foreach ($typeLeave as $item)
                                    <option value="{{$item->id}}">{{$item->type_leave}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="leave-form-category">
                            <select name="category_leave" id="category_leave" class="form-control">
                                <option>Pilih Kategori</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-laeve">Submit</button>
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });

            $('#type_leave').attr("disabled", true);
            $('#category_leave').attr("disabled", true);
        })

        function selectDate(date) {
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

        $('#form-leave').on('submit', function (e) {
            e.preventDefault();
            var typeLeave = $('#type_leave').find(":selected").val();
            var categoryLeave = $('#category_leave').find(":selected").val();
            var clickDate = $('.week').find('.selected').attr('data-date');
            var startDate = convertDate(clickDate);
            
            $.ajax({
                url: "{{route('requestLeave')}}",
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
                        +   '<div class="section-leave-form">'
                        +       '<div class="section-leave-form-type">'
                        +           '<div class="row">'
                        +               '<div class="col-md-6 col-xs-12 mb-2">'
                        +                   '<div class="section-leave-form-type-label">'
                        +                       'Tanggal Awal Cuti'
                        +                   '</div>'
                        +                   '<input type="date" class="form-control" name="start_date" id="start_date" value="'+startDate+'" disabled>'
                        +               '</div>'
                        +               '<div class="col-md-6 col-xs-12 mb-2">'
                        +                   '<div class="section-leave-form-type-label">'
                        +                       'Tanggal Akhir Cuti'
                        +                   '</div>'
                        +                   '<input type="date" class="form-control" name="end_date" id="end_date">'
                        +               '</div>'
                        +           '</div>'
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

    </script>
@endsection