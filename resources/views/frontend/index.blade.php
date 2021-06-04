@extends('layouts.frontend.main')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<style>
    html body {
        background: #1e64b1;
    }
    .sidebar .sidebar_innr .sections li.active a {
        color: #1e64b1;
    }
</style>

<div class="main_content_inner">
    <div uk-grid>
        <div class="uk-width-2-3@m fead-area">
            <div class="post">
                <div class="post-heading">
                    <div class="post-title">
                        <h4> HRIS.TEDC </h4>
                    </div>
                </div>
                <div class="post-description">
                    <p>
                        Aplikasi Web HRIS.TEDC merupakan platform untuk manajemen cuti & lembur bagi para karyawan Politeknik TEDC Bandung.
                        Dengan aplikasi ini, karyawan akan lebih mudah melakukan pengajuan cuti, memantau approval cuti, melakukan pengajuan lembur,
                        dan memantau approval lembur.
                    </p>
                    <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
                        euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                        Ut wisi enim ad minim laoreet dolore magna aliquam erat volutpat
                    </p>
                </div>
            </div>
            <div class="uk-width-expand">
                <div class="sl_sidebar_sugs_title mt-4">
                    Pro Members
                </div>
                <div class="uk-position-relative" uk-slider="finite: true; autoplay:true">

                    <div class="uk-slider-container pb-3">

                        <ul class="uk-slider-items uk-child-width-1-3@m uk-grid-small uk-grid sl_pro_users">
                            @foreach ($slider as $item)
                                <li>
                                    <a class="user" href="#">
                                        <img src="{{asset('storage/'.$item->image)}}" alt="">
                                        <span>{{$item->caption}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <a class="uk-position-center-left uk-hidden-hover slidenav-prev sl_pro_users_prev"
                            href="#" uk-slider-item="previous"></a>
                        <a class="uk-position-center-right-out uk-position-small uk-hidden-hover slidenav-next sl_pro_users_next"
                            href="#" uk-slider-item="next"></a>
                    </div>
                </div>

            </div>
            <div class="post">
                <div class="post-heading">
                    <div class="post-title">
                        <h4> What is Lorem Ipsum? </h4>
                    </div>
                </div>
                <div class="post-description">
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        It has survived not only five centuries, but also the leap into electronic typesetting, 
                        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection