@extends('layouts.backend.master')

@section('title-header')
    Role
@endsection

@section('menus')
    User Config
@endsection

@section('submenus')
    Role
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Role</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.role.'. (isset($role) ? 'update' : 'store') )}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($role) ? "$role->id" : '')}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">Nama Role</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Role" value="{{(isset($role) ? "$role->name" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Deskripsi</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="description" id="description" placeholder="Deskripsi" value="{{(isset($role) ? "$role->description" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.role.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($role) ? 'Update' : 'Simpan')}}</button>
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
                    'name' : {
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
