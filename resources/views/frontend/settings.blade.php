@extends('layouts.frontend.master')

@section('title')
    <title>Pengaturan</title>
@endsection

@section('content')
    <div class="appCapsule">
        <div class="section mt-3 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-end">
                    <div>
                        <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">
                            Mode Gelap
                        </h5>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input dark-mode-switch" id="darkmodeswitch">
                        <label class="custom-control-label" for="darkmodeswitch"></label>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection