@extends('layouts.backend.master')

@section('title-header')
    Report Cuti/Izin
@endsection

@section('menus')
    Report
@endsection

@section('submenus')
    Report Cuti/Izin
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Report Cuti/Izin</h5>
        </div>
        <div class="panel-body">
            <form class="form-group row" action="{{route('admin.report.leave.download')}}" target="_blank">
                {{ csrf_field() }}
                <div class="col-md-4">
                    <select name="empl_id" class="form-control" id="empl_id">
                        <option value="null" selected>Semua Pegawai</option>
                        @foreach ($empl as $item)
                            <option value="{{$item->id}}">{{$item->empl_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Tanggal Awal" onfocus="(this.type='date')">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="end_date" id="end_date" placeholder="Tanggal Akhir" onfocus="(this.type='date')">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Download Report
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/admin/js/form-validator/jquery.form-validator.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var config = {
                form : 'form',
                validate : {
                    'start_date' : {
                        validation : 'required'
                    },
                    'end_date' : {
                        validation : 'required'
                    }
                }
            };

            $.validate({
                modules : 'jsconf, security',
                onModulesLoaded : function() {
                    $.setupValidation(config);
                }
            });
        })
    </script>
@endsection