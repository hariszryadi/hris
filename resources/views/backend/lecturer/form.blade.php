@extends('layouts.backend.master')

@section('title-header')
    Dosen
@endsection

@section('menus')
    Data
@endsection

@section('submenus')
    Dosen
@endsection

@section('content')
    <style>
        .form-text {
            display: block;
            margin-top: .5rem;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Dosen</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.lecturer.'. (isset($lecturer) ? 'update' : 'store') )}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($lecturer) ? "$lecturer->id" : '')}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">No Registrasi</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="no_reg" id="no_reg" placeholder="Nomor Registrasi" value="{{(isset($lecturer) ? "$lecturer->no_reg" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Nama Dosen</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Dosen" value="{{(isset($lecturer) ? "$lecturer->name" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Jabatan Fungional</label>
                    <div class="col-lg-6">
                        <select name="functional_position_id" id="functional_position" class="form-control">
                            <option selected disabled>Pilih Jabatan Fungsional</option>
                            @foreach ($functional_position as $item)
                                <option value="{{$item->id}}" {{(isset($lecturer) ? ($lecturer->functional_position_id == $item->id ? 'selected' : '') : '')}}>{{$item->name}}</option>                
                            @endforeach
                            <option value="" {{(isset($lecturer) ? ($lecturer->functional_position_id == '' ? 'selected' : '') : '')}}>-</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-lg-2">Kepangkatan</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="rank" id="rank" placeholder="Kepangkatan" value="{{(isset($lecturer) ? "$lecturer->rank" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Pendidikan Terakhir</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="last_education" id="last_education" placeholder="Pendidikan Terakhir" value="{{(isset($lecturer) ? "$lecturer->last_education" : '')}}">
                        <span class="form-text text-muted">*contoh : D4 - Politeknik TEDC Bandung</span>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Status Serdos</label>
                    <div class="col-lg-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="certification" id="not_certification" value="false" {{(isset($lecturer) ? ($lecturer->certification == false ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="not_certification">Belum Tersertifikasi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="certification" id="done_certification" value="true" {{(isset($lecturer) ? ($lecturer->certification == true ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="done_certification">Sertifikasi Dosen</label>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Tahun Sertifikasi</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="certification_year" id="certification_year" placeholder="Tahun Sertifikasi" value="{{(isset($lecturer) ? "$lecturer->certification_year" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Penempatan</label>
                    <div class="col-lg-6">
                        <select name="major_id" id="major" class="form-control">
                            <option selected disabled>Pilih Penempatan</option>
                            @foreach ($major as $item)
                                <option value="{{$item->id}}" {{(isset($lecturer) ? ($lecturer->major_id == $item->id ? 'selected' : '') : '')}}>{{$item->name}}</option>                
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Foto Dosen</label>
                    <div class="col-lg-10">
                        <input type="file" class="form-control" name="avatar" id="avatar" value="{{(isset($lecturer) ? "$lecturer->avatar" : '')}}">
                        <span class="help-block"></span>
                        <span id="temp_image">
                            @if (isset($lecturer))
                                <img src="{{ asset('storage/'.$lecturer->avatar) }}" class="img-thumbnail img-empl" onerror="this.src='{{asset('assets/admin/images/placeholder.jpg')}}';"/>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.lecturer.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($lecturer) ? 'Update' : 'Simpan')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/admin/js/form-validator/jquery.form-validator.min.js')}}"></script>
    
    <script>
        $(document).ready(function () {
            var previews = $('#temp_image');
            var config = {
                form : 'form',
                validate : {
                    'no_reg' : {
                        validation : 'required'
                    },
                    'name' : {
                        validation : 'required'
                    },
                    'last_education' : {
                        validation : 'required'
                    },
                    'certification' : {
                        validation : 'required'
                    },
                    'major_id' : {
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
                                    "class": "img-thumbnail img-empl",
                                }).appendTo(previews);
                        };
                        reader.readAsDataURL(file);
                    })
            })
        
            $(document).on("input", "#no_reg", function() {
                this.value = this.value.replace(/\D/g,'');
            });

            $(document).on("input", "#certification_year", function() {
                this.value = this.value.replace(/\D/g,'');
            });

            $(document).on("input", "#name", function() {
                this.value = this.value.toUpperCase();
            });
        });

    </script>
@endsection
