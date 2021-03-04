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
            <form class="form-horizontal" id="form" action="{{route('admin.employee.'. (isset($employee) ? 'update' : 'store') )}}" method="POST" enctype="multipart/form-data">
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
                    <label class="control-label col-lg-2">Tanggal Lahir</label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{(isset($employee) ? "$employee->birth_date" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-lg-2">Alamat</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="address" id="address" placeholder="Alamat" value="{{(isset($employee) ? "$employee->address" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Telepon</label>
                    <div class="col-lg-1">
                        <input type="text" class="form-control" value="+62" disabled>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Telepon" value="{{(isset($employee) ? "$employee->phone" : '')}}">
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
                            <option value="Pria" {{(isset($employee) ? ($employee->gender == 'Pria' ? 'selected' : '') : '')}}>Pria</option>
                            <option value="Wanita" {{(isset($employee) ? ($employee->gender == 'Wanita' ? 'selected' : '') : '')}}>Wanita</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Agama</label>
                    <div class="col-lg-3">
                        <select name="religion" id="religion" class="form-control">
                            <option selected disabled>Pilih Agama</option>
                            <option value="Islam" {{(isset($employee) ? ($employee->religion == 'Islam' ? 'selected' : '') : '')}}>Islam</option>
                            <option value="Protestan" {{(isset($employee) ? ($employee->religion == 'Protestan' ? 'selected' : '') : '')}}>Protestan</option>
                            <option value="Katolik" {{(isset($employee) ? ($employee->religion == 'Katolik' ? 'selected' : '') : '')}}>Katolik</option>
                            <option value="Hindu" {{(isset($employee) ? ($employee->religion == 'Hindu' ? 'selected' : '') : '')}}>Hindu</option>
                            <option value="Buddha" {{(isset($employee) ? ($employee->religion == 'Buddha' ? 'selected' : '') : '')}}>Buddha</option>
                            <option value="Konghucu" {{(isset($employee) ? ($employee->religion == 'Konghucu' ? 'selected' : '') : '')}}>Konghucu</option>
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
                                <option value="{{$item->id}}" {{(isset($employee) ? ($employee->division_id == $item->id ? 'selected' : '') : '')}}>{{$item->name}}</option>                
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Foto Pegawai</label>
                    <div class="col-lg-10">
                        <input type="file" class="form-control" name="image" id="image" value="{{(isset($employee) ? "$employee->image" : '')}}">
                        <span class="help-block"></span>
                        <span id="store_image">
                            @if (isset($employee))
                                <img src="{{ asset('storage/'.$employee->image) }}" class="img-thumbnail" />
                            @endif
                        </span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.employee.index')}}">Kembali</a>
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
            var previews = $('#store_image');
            var config = {
                form : 'form',
                validate : {
                    'nip' : {
                        validation : 'required'
                    },
                    'empl_name' : {
                        validation : 'required'
                    },
                    'birth_date' : {
                        validation : 'required'
                    },
                    'address' : {
                        validation : 'required'
                    },
                    'phone' : {
                        validation : 'required'
                    },
                    'email' : {
                        validation : 'required'
                    },
                    'gender' : {
                        validation : 'required'
                    },
                    'religion' : {
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

            $("input[type=file]").on("change", function (e) {
                if (this.files[0].size > 2097152) {
                    bootbox.alert('Upload file max 2 MB');
                    this.value = null;
                }
                previews.empty();
                Array.prototype.slice.call(e.target.files)
                    .forEach(function (file, idx) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $("<img/>", {
                                    "src": event.target.result,
                                    "class": idx,
                                    "class": "img-thumbnail",
                                }).appendTo(previews);
                        };
                        reader.readAsDataURL(file);
                    })
            })
        
            $(document).on("input", "#phone", function() {
                this.value = this.value.replace(/[^0-9\.]/g,'');
            });
        });

    </script>
@endsection
