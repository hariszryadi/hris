@extends('layouts.frontend.master')

@section('title')
    <title>Dashboard</title>
@endsection

@section('pageTitle')
    Dashboard
@endsection

@section('content')
    <div class="appCapsule">

        <div class="header-large-title">
            <h2 class="title">What is Lorem Ipsum?</h2>
            <h4 class="subtitle">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</h4>
        </div>

        <div class="section full mt-3 mb-3">
            <div class="carousel-multiple owl-carousel owl-theme">

                <div class="item">
                    <div class="card">
                        <img src="assets/img/sample/photo/d1.jpg" class="card-img-top" alt="image">
                        <div class="card-body pt-2">
                            <h4 class="mb-0">Progressive web app ready</h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="assets/img/sample/photo/d2.jpg" class="card-img-top" alt="image">
                        <div class="card-body pt-2">
                            <h4 class="mb-0">Reusable components</h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="assets/img/sample/photo/d3.jpg" class="card-img-top" alt="image">
                        <div class="card-body pt-2">
                            <h4 class="mb-0">Great for phones & tablets</h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="assets/img/sample/photo/d4.jpg" class="card-img-top" alt="image">
                        <div class="card-body pt-2">
                            <h4 class="mb-0">Change the styles in one file</h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="assets/img/sample/photo/d6.jpg" class="card-img-top" alt="image">
                        <div class="card-body pt-2">
                            <h4 class="mb-0">Sketch source file included</h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="assets/img/sample/photo/d5.jpg" class="card-img-top" alt="image">
                        <div class="card-body pt-2">
                            <h4 class="mb-0">Written with a code structure</h4>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="section mt-3 mb-3">
            <div class="card">
                <img src="assets/img/sample/photo/wide2.jpg" class="card-img-top" alt="image">
                <div class="card-body">
                    <h6 class="card-subtitle">Discover</h6>
                    <h5 class="card-title">Pages</h5>
                    <p class="card-text">
                        Mobilekit comes with basic pages you may need and use in your projects easily.
                    </p>
                    <a href="app-pages.html" class="btn btn-primary">
                        <ion-icon name="layers-outline"></ion-icon>
                        Preview
                    </a>
                </div>
            </div>
        </div>

    </div>
    
@endsection