@extends('layouts.backend.master')

@section('title-header')
    Kategori Cuti/Izin
@endsection

@section('menus')
    Master
@endsection

@section('submenus')
    Kategori Cuti/Izin
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Kategori Cuti/Izin</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.categoryLeave.'. (isset($categoryLeave) ? 'update' : 'store') )}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($categoryLeave) ? "$categoryLeave->id" : '')}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">Kategori</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="category_leave" id="category_leave" placeholder="Kategori Cuti/Izin" value="{{(isset($categoryLeave) ? "$categoryLeave->category_leave" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Tipe Cuti/Izin</label>
                    <div class="col-lg-6">
                        <select name="type_leave_id" id="type_leave" class="form-control">
                            <option selected disabled>Pilih Tipe</option>
                            @foreach ($typeLeave as $item)
                                <option value="{{$item->id}}" {{(isset($categoryLeave) ? ($categoryLeave->type_leave_id == $item->id ? 'selected' : '') : '')}}>{{$item->type_leave}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.categoryLeave.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($categoryLeave) ? 'Update' : 'Simpan')}}</button>
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
                    'category_leave' : {
                        validation : 'required'
                    },
                    'type_leave_id' : {
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
