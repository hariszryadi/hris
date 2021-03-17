@extends('layouts.backend.master')

@section('title-header')
    Slider
@endsection

@section('menus')
    CMS
@endsection

@section('submenus')
    Slider
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Slider</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.slider.'. (isset($slider) ? 'update' : 'store') )}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($slider) ? "$slider->id" : '')}}">
                </div>		

                <div class="form-group">
                    <label class="control-label col-lg-2">Image</label>
                    <div class="col-lg-10">
                        <input type="file" class="form-control" name="image" id="image" value="{{(isset($slider) ? "$slider->image" : '')}}">
                        <span class="help-block"></span>
                        <span id="temp_image">
                            @if (isset($slider))
                                <img src="{{ asset('storage/'.$slider->image) }}" class="img-thumbnail img-slider" />
                            @endif
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Caption</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="caption" id="caption" placeholder="Caption" value="{{(isset($slider) ? "$slider->caption" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.slider.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($slider) ? 'Update' : 'Simpan')}}</button>
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
                    'caption' : {
                        validation : 'required, length, custom',
				        length : '2-50'
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
                                    "class": "img-thumbnail img-slider",
                                }).appendTo(previews);
                        };
                        reader.readAsDataURL(file);
                    })
            })
        });

    </script>
@endsection
