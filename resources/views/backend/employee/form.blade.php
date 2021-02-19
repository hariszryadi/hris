@extends('layouts.backend.master')

@section('title-header')
    Pegawai
@endsection

@section('menus')
    Master
@endsection

@section('submenus')
    Pegawai
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Pegawai</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.employee.'. (isset($employee) ? 'update' : 'store') )}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($employee) ? "$employee->id" : '')}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">NIP Pegawai</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP Pegawai" value="{{(isset($employee) ? "$employee->nip" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Nama Pegawai</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="empl_name" id="empl_name" placeholder="Nama Pegawai" value="{{(isset($employee) ? "$employee->empl_name" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-lg-2">Email</label>
                    <div class="col-lg-10">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{(isset($employee) ? "$employee->email" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Jenis Kelamin</label>
                    <div class="col-lg-3">
                        <select name="gender" id="gender" class="form-control">
                            <option selected disabled>Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>                            
                            <option value="Wanita">Wanita</option>                            
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Agama</label>
                    <div class="col-lg-3">
                        <select name="religion" id="religion" class="form-control">
                            <option selected disabled>Pilih Agama</option>
                            <option value="Islam">Islam</option>                            
                            <option value="Protestan">Protestan</option>                            
                            <option value="Katolik">Katolik</option>                            
                            <option value="Hindu">Hindu</option>                            
                            <option value="Buddha">Buddha</option>                            
                            <option value="Konghucu">Konghucu</option>                            
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Divisi Pegawai</label>
                    <div class="col-lg-6">
                        <select name="division_id" id="division" class="form-control">
                            <option selected disabled>Pilih Divisi</option>
                            @foreach ($division as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>                            
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.division.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($employee) ? 'Update' : 'Simpan')}}</button>
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
                    'nip' : {
                        validation : 'required'
                    },
                    'empl_name' : {
                        validation : 'required'
                    },
                    'division_id' : {
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
        });
    </script>
@endsection
