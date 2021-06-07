@extends('layouts.backend.master')

@section('title-header')
    Account Pegawai
@endsection

@section('menus')
    User Config
@endsection

@section('submenus')
    Account Pegawai
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Account Pegawai</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.account.update')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$account->id}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">NIP</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="nip" id="nip" value="{{$account->nip}}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Nama Pegawai</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="name" id="name" value="{{$account->name}}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Password</label>
                    <div class="col-lg-10">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.account.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
