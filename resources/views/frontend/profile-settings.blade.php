@extends('layouts.frontend.main')

@section('title')
    <title>Pengaturan</title>
@endsection

@section('content')
<style>
    html body {
        background: #1e64b1;
    }
    .sidebar .sidebar_innr .sections li.active a {
        color: #1e64b1;
    }
    .form-error {
        color: rgb(185, 74, 72);
    }
</style>

<div class="main_content_inner">
    <div uk-grid>
        <div class="uk-width-2-3@m fead-area">
            <!-- Component Alert --> 
            @include('helper.notify')
            <!-- End Component Alert -->
            <div class="post">
                <div class="post-heading">
                    <div class="post-title" style="margin-left: 0px !important;">
                        <div class="text-center">
                            <h4>Pengaturan Profile</h4>
                        </div>
                    </div>
                </div>
                <div class="post-description">
                    <form id="update-profile" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$empl->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="empl_name">Nama</label>
                                    <input type="text" class="form-control" id="empl_name" value="{{$empl->empl_name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control" id="nip" value="{{$empl->nip}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="division">Divisi Pegawai</label>
                                    <select id="division" class="form-control" disabled>
                                        <option selected disabled>Pilih Divisi</option>
                                        @foreach ($division as $item)
                                            <option value="{{$item->id}}" {{($empl->division_id == $item->id ? 'selected' : '')}}>{{$item->name}}</option>                
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="birth_date">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{($empl->birth_date)}}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Telepon</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{($empl->phone)}}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{($empl->email)}}">
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <input type="text" class="form-control" name="address" id="address" value="{{($empl->address)}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="Pria" {{($empl->gender == 'Pria' ? 'selected' : '')}}>Pria</option>
                                        <option value="Wanita" {{($empl->gender == 'Wanita' ? 'selected' : '')}}>Wanita</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="religion">Agama</label>
                                    <select name="religion" id="religion" class="form-control">
                                        <option selected disabled>Pilih Agama</option>
                                        <option value="Islam" {{($empl->religion == 'Islam' ? 'selected' : '')}}>Islam</option>
                                        <option value="Protestan" {{($empl->religion == 'Protestan' ? 'selected' : '')}}>Protestan</option>
                                        <option value="Katolik" {{($empl->religion == 'Katolik' ? 'selected' : '')}}>Katolik</option>
                                        <option value="Hindu" {{($empl->religion == 'Hindu' ? 'selected' : '')}}>Hindu</option>
                                        <option value="Buddha" {{($empl->religion == 'Buddha' ? 'selected' : '')}}>Buddha</option>
                                        <option value="Konghucu" {{($empl->religion == 'Konghucu' ? 'selected' : '')}}>Konghucu</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="avatar">Foto Pegawai</label>
                                    <input type="file" class="form-control" name="avatar" id="avatar" value="{{($empl->avatar)}}">
                                    <div class="text-center">
                                        <span id="temp_image">
                                            <img src="{{ asset('storage/'.$empl->avatar) }}" class="img-thumbnail img-empl" 
                                            @if ($empl->gender == 'Pria')
                                                onerror="this.src='{{asset('assets/admin/images/male.png')}}';"
                                            @endif 
                                                onerror="this.src='{{asset('assets/admin/images/female.png')}}';"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin: 16px 0px;">
                                <div class="text-center">
                                    <a href="{{route('dashboard')}}" class="btn btn-warning">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Ubah Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('assets/admin/js/form-validator/jquery.form-validator.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var _token = '{{ csrf_token() }}';
        var previews = $('#temp_image');
        var config = {
            form : 'form',
            validate : {
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
                }
            }
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': _token
            }
        });
        
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
    })


    $('#update-profile').on('submit', function (e) {
        e.preventDefault();
        loadingproses();

        $.ajax({
            url: "{{route('updateProfile')}}",
            method: "POST",
            dataType: "json",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                $('.alert-danger').attr("hidden", true);
                $('.alert-success').attr("hidden", false);
                $('.alert-success strong').text(data.message);
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                loadingproses_close();
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log(err.message);
                $('.alert-success').attr("hidden", true);
                $('.alert-danger').attr("hidden", false);
                $('.alert-danger strong').text(err.message);
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                loadingproses_close();
            }
        })
    })
</script>
    
@endsection