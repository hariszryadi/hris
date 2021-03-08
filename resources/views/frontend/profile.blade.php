@extends('layouts.frontend.master')

@section('title')
    <title>Profile</title>
@endsection

@section('pageTitle')
    Profile
@endsection

@section('content')
    <div class="appCapsule">
        <div class="section mt-2">
            <div class="row row-header">
                <div class="col-12">
                    <img src="{{asset('storage/'.Auth::user()->empl->avatar)}}" alt="avatar" class="imaged rounded avatar-profile"
                    @if (Auth::user()->empl->gender == 'Pria')
                        onerror="this.src='{{asset('assets/admin/images/male.png')}}';"
                    @endif 
                        onerror="this.src='{{asset('assets/admin/images/female.png')}}';">
                </div>
            </div>
            <div class="row row-header">
                <div class="col-12">
                    <h2 class="name">{{Auth::user()->empl->empl_name}}</h2>
                    <h3 class="subtext">{{Auth::user()->empl->nip}}</h3>
                </div>
            </div>
        </div>

        <div class="section mt-2">
            <div class="row row-body">
                <div class="col-12 col-body-profile">
                    Tanggal Lahir
                    <br>
                    <span id="birth-date">{{Auth::user()->empl->birth_date}}</span>
                </div>
                <div class="col-12 col-body-profile">
                    Alamat
                    <br>
                    <span>{{Auth::user()->empl->address}}</span>
                </div>
                <div class="col-12 col-body-profile">
                    Telepon
                    <br>
                    <span>+{{Auth::user()->empl->phone}}</span>
                </div>
                <div class="col-12 col-body-profile">
                    Email
                    <br>
                    <span>{{Auth::user()->empl->email}}</span>
                </div>
                <div class="col-12 col-body-profile">
                    Jenis Kelamin
                    <br>
                    <span>{{Auth::user()->empl->gender}}</span>
                </div>
                <div class="col-12 col-body-profile">
                    Agama
                    <br>
                    <span>{{Auth::user()->empl->religion}}</span>
                </div>
                <div class="col-12 col-body-profile">
                    Divisi
                    <br>
                    <span>{{Auth::user()->empl->division->name}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var birthDate = $('#birth-date').text();
            $('#birth-date').html(dateFormat(birthDate));
        })

        function dateFormat(date) {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            var t = new Date(date);
            var newDate = t.getDate() + '-' + monthNames[t.getMonth()] + '-' + t.getFullYear();
            return newDate;
        }
    </script>
@endsection