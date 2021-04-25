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
                        <h4> HRIS-Ku </h4>
                    </div>
                </div>
                <div class="post-description">

                    <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
                        euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                        Ut wisi enim ad minim laoreet dolore magna aliquam erat volutpat</p>

                </div>

            </div>
            <div class="uk-width-expand">

                <div class="sl_sidebar_sugs_title mt-4">
                    Pro Members
                </div>

                <div class="uk-position-relative" uk-slider="finite: true; autoplay:true">

                    <div class="uk-slider-container pb-3">

                        <ul class="uk-slider-items uk-child-width-1-3@m uk-grid-small uk-grid sl_pro_users">
                            <li>
                                <a class="user" href="#">
                                    <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                    <span>Stella Johnson 1</span>
                                </a>
                            </li>
                            <li>
                                <a class="user" href="#">
                                    <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                    <span>Stella Johnson 2</span>
                                </a>
                            </li>
                            <li>
                                <a class="user" href="#">
                                    <img src="assets/images/avatars/avatar-3.jpg" alt="">
                                    <span>Stella Johnson 3</span>
                                </a>
                            </li>
                            <li>
                                <a class="user" href="#">
                                    <img src="assets/images/avatars/avatar-4.jpg" alt="">
                                    <span>Stella Johnson 4</span>
                                </a>
                            </li>
                            <li>
                                <a class="user" href="#">
                                    <img src="assets/images/avatars/avatar-5.jpg" alt="">
                                    <span>Stella Johnson 5</span>
                                </a>
                            </li>
                            <li>
                                <a class="user" href="#">
                                    <img src="assets/images/avatars/avatar-5.jpg" alt="">
                                    <span>Stella Johnson 5</span>
                                </a>
                            </li>
                        </ul>

                        <a class="uk-position-center-left uk-hidden-hover slidenav-prev sl_pro_users_prev"
                            href="#" uk-slider-item="previous"></a>
                        <a class="uk-position-center-right-out uk-position-small uk-hidden-hover slidenav-next sl_pro_users_next"
                            href="#" uk-slider-item="next"></a>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection