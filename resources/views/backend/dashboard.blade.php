@extends('layouts.backend.master')

@section('title-header')
    Dashboard
@endsection

@section('menus')
    Dashboard
@endsection

@section('content')
    <style>
        .card {
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .1875rem;
        }
        .card-body {
            padding: 1.25rem;
        }
        .media {
            display: flex; 
        }
        .media-body {
            flex: 1;
        }
        .align-self-center {
            margin-left: 1.25rem!important; 
            align-self: center!important;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h1>Selamat Datang di Dashboard Admin HRIS.TEDC</h1>
        </div>
        <div class="panel-body">
            <p class="text-justify">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </p>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-body bg-blue-400 has-bg-image">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">54,390</h3>
                                <span class="text-uppercase font-size-xs">jumlah dosen</span>
                            </div>
    
                            <div class="ml-3 align-self-center">
                                <i class="icon-users2 icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-6">
                    <div class="card card-body bg-danger-400 has-bg-image">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">389,438</h3>
                                <span class="text-uppercase font-size-xs">jumlah pegawai</span>
                            </div>
    
                            <div class="ml-3 align-self-center">
                                <i class="icon-users4 icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
    
                {{-- <div class="col-lg-3">
                    <div class="card card-body bg-success-400 has-bg-image">
                        <div class="media">
                            <div class="mr-3 align-self-center">
                                <i class="icon-user icon-3x opacity-75"></i>
                            </div>
    
                            <div class="media-body text-right">
                                <h3 class="mb-0">652,549</h3>
                                <span class="text-uppercase font-size-xs">total clicks</span>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-3">
                    <div class="card card-body bg-indigo-400 has-bg-image">
                        <div class="media">
                            <div class="mr-3 align-self-center">
                                <i class="icon-users icon-3x opacity-75"></i>
                            </div>
    
                            <div class="media-body text-right">
                                <h3 class="mb-0">245,382</h3>
                                <span class="text-uppercase font-size-xs">total visits</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.card').mouseover(function () {
            $('.card').css('cursor', 'pointer')
        })
    </script>
@endsection