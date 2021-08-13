@extends('layouts.backend.master')

@section('title-header')
    Finger
@endsection

@section('menus')
    Import
@endsection

@section('submenus')
    Finger
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Set ID Finger</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.finger.'. (isset($finger) ? 'update' : 'store') )}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($finger) ? "$finger->id" : '')}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">NIP Pegawai</label>
                    <div class="col-lg-4">
                        <select name="nip" class="form-control" id="nip">
                            <option value="null" selected disabled>Pilih Pegawai</option>
                            @foreach ($empl as $item)
                                <option value="{{$item->nip}}" {{(isset($finger) ? ($finger->nip == $item->nip ? 'selected' : '') : '')}}>{{$item->nip}} - {{$item->empl_name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">ID Finger</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="id_finger" id="id_finger" placeholder="ID Finger" value="{{(isset($finger) ? "$finger->id_finger" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.finger.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($division) ? 'Update' : 'Simpan')}}</button>
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
                    'id_finger' : {
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

            $(document).on("input", "#id_finger", function() {
                this.value = this.value.replace(/[^0-9\.]/g,'');
            });
        });
    </script>
@endsection
