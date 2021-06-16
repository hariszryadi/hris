@extends('layouts.backend.master')

@section('title-header')
    Ubah Password
@endsection

@section('menus')
    Ubah Password
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Ubah Password</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form-change-password" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                </div>			

                <div class="form-group">
                    <label class="control-label col-lg-3">Password Lama</label>
                    <div class="col-lg-9">
                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Masukkan Password Lama">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-3">Password Baru</label>
                    <div class="col-lg-9">
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Masukkan Password Baru">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-3">Konfirmasi Password Baru</label>
                    <div class="col-lg-9">
                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Masukkan Konfirmasi Password Baru">
                        <span id="check-confirm-password"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.dashboard')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
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
                    'old_password' : {
                        validation : 'required'
                    },
                    'new_password' : {
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

        $('#confirm_new_password').on('keyup', function(){
            var newPassword = $('#new_password').val();
            var confirmNewPassword = $('#confirm_new_password').val();
            if (newPassword != confirmNewPassword) {
                $('#check-confirm-password').text('Password does not match !').css('color','#D84315');
                $('#confirm_new_password').css('border-color','#D84315');
                return false;
            } else {
                $('#check-confirm-password').html('Password match !').css('color','#43A047');
                $('#confirm_new_password').css('border-color','#43A047');
                return true;
            }
        });

        $('#form-change-password').on('submit', function (e) {
            e.preventDefault();

            if ($('#confirm_new_password').val() == '') {
                $('#check-confirm-password').text('This is a required field').css('color','#D84315');
                $('#confirm_new_password').css('border-color','#D84315');
                return false;
            }

            if ($('#check-confirm-password').text() == 'Password match !') {
                $.ajax({
                    url: "{{route('admin.changePassword.update')}}",
                    type: "POST",
                    data: $('#form-change-password').serialize(),
                    success: function (resp) {
                        swal({
                                title: "Sukses!", 
                                text: resp.message, 
                                type: "success"
                            },
                            function(){ 
                                location.reload();
                            }
                        );
                    },
                    error: function (err) {
                        var errors = err.responseJSON;
                        swal({
                                title: "Error!", 
                                text: errors.message, 
                                type: "error"
                            },
                            function(){ 
                                location.reload();
                            }
                        );
                    }
                })
            } else {
                return false;
            }

        })
    </script>
@endsection
