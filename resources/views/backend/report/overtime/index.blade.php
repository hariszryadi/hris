@extends('layouts.backend.master')

@section('title-header')
    Report Lembur
@endsection

@section('menus')
    Report
@endsection

@section('submenus')
    Report Lembur
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Report Lembur</h5>
        </div>
        <div class="panel-body">
            <form class="form-group row" action="{{route('admin.report.overtime.download')}}" target="_blank">
                {{ csrf_field() }}
                <div class="col-md-4">
                    <select name="empl_id" class="form-control">
                        <option value="null" selected>Semua Pegawai</option>
                        @foreach ($empl as $item)
                            <option value="{{$item->id}}">{{$item->empl_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="month" class="form-control">
                        <option value="null" selected>Semua Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="year" class="form-control">
                        <option value="2021">2021</option>
                    </select>
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