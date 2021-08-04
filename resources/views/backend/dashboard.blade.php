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
            cursor: pointer;
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
                    <div class="card card-body bg-blue-400 has-bg-image" id="card-lecturer">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{ \App\Models\MsLecturer::count() }}</h3>
                                <span class="text-uppercase font-size-xs">jumlah dosen</span>
                            </div>
    
                            <div class="ml-3 align-self-center">
                                <i class="icon-graduation icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-6">
                    <div class="card card-body bg-danger-400 has-bg-image" id="card-employee">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{ \App\Models\MsEmployee::count() }}</h3>
                                <span class="text-uppercase font-size-xs">jumlah pegawai</span>
                            </div>
    
                            <div class="ml-3 align-self-center">
                                <i class="icon-users icon-3x opacity-75"></i>
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

    <!-- Modal detail -->
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Jumlah Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            var _token = '{{ csrf_token() }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });

            $('#card-lecturer').on('click', function () {
                $('#modal-detail').modal('show');

                $.ajax({
                    url: "{{route('admin.getCountLecturer')}}",
                    method: "POST",
                    success: function (resp) {
                        console.log(resp);
                        chartLecturer(resp.asisten_ahli, resp.lektor, resp.lektor_kepala, resp.guru_besar, resp.tenaga_pengajar);
                    }
                })
            })
        })

        function chartLecturer(params1, params2, params3, params4, params5) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar', 'Tenaga Pengajar'],
                    datasets: [{
                        label: 'Jumlah Dosen',
                        data: [params1, params2, params3, params4, params5],
                        backgroundColor: [
                            'rgb(41, 182, 246)',
                            'rgb(239, 83, 80)',
                            'rgb(102, 187, 106)',
                            'rgb(185, 176, 69)',
                            'rgb(92, 107, 192)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
    </script>
@endsection