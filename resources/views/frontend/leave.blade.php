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
                    <form action="">
                        <div class="leave-form-type">
                            <select name="select_type_leave" id="select_type_leave" class="form-control">
                                <option>Pilih Type</option>
                                <option value="">Cuti</option>
                                <option value="">Izin</option>
                            </select>
                        </div>
                        <div class="leave-form-category">
                            <select name="select_category_leave" id="select_category_leave" class="form-control">
                                <option >Pilih Kategori</option>
                                <option value="">Kategori Cuti</option>
                                <option value="">Kategori Izin</option>
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
            $('#select_type_leave').attr("disabled", true);
            $('#select_category_leave').attr("disabled", true);
        })

        function selectDate(date) {
            $('.calendar-wrapper').updateCalendarOptions({
                date: date
            });
            $('#select_type_leave').attr("disabled", false);
            $('#select_category_leave').attr("disabled", false);
        }

        var defaultConfig = {
            weekDayLength: 1,
            date: new Date(),
            onClickDate: selectDate,
            showYearDropdown: true,
        };

        $('.calendar-wrapper').calendar(defaultConfig);

    </script>
@endsection