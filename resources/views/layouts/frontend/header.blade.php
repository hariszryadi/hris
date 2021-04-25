<header>
    <div class="header-innr">

        <!-- Logo-->
        <div class="header-btn-traiger is-hidden" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
            <span></span></div>

         <!-- Logo-->
         <div id="logo">
            <a href="#"> <img src="{{asset('images/logo.png')}}" alt=""></a>
            <a href="#"> <img src="{{asset('images/logo.png')}}" class="logo-inverse" alt=""></a>
        </div>

        <!-- form search-->
        <div class="head_search">
            <form>
                <div class="head_search_cont">
                    <input value="" type="text" class="form-control"
                        placeholder="Search..." autocomplete="off">
                    <i class="s_icon uil-search-alt"></i>
                </div>

                <!-- Search box dropdown -->
                <div uk-dropdown="pos: top;mode:click;animation: uk-animation-slide-bottom-small"
                    class="dropdown-search display-hidden">
                    <!-- User menu -->

                    <ul class="dropdown-search-list">
                        <li class="list-title"> Recent Searches </li>
                        <li></li>
                        <li class="menu-divider"></li>
                        <li class="list-footer"> <a href="your-history.html"> Searches History </a>
                        </li>
                    </ul>

                </div>


            </form>
        </div>

        <!-- user icons -->
        <div class="head_user">

            <!-- notificiation icon  -->
            <a href="#" class="opts_icon" uk-tooltip="title: Notifications ; pos: bottom ;offset:7">
                <i class="icon-material-outline-notifications-active" style="font-size:24px;"></i> <span>3</span>
            </a>


            <!-- notificiation dropdown -->
            <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                class="dropdown-notifications display-hidden">

                <!-- notification contents -->
                <div class="dropdown-notifications-content" data-simplebar>

                    <!-- notivication header -->
                    <div class="dropdown-notifications-headline">
                        <h4>Notifications </h4>
                    </div>

                    <!-- notivication list -->
                    <ul>
                        <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                </span>
                                <span class="notification-icon bg-gradient-primary">
                                    <i class="icon-feather-thumbs-up"></i></span>
                                <span class="notification-text">
                                    <strong>Adrian Moh.</strong> Like Your Comment On Video
                                    <span class="text-primary">Learn Prototype Faster</span>
                                    <br> <span class="time-ago"> 9 hours ago </span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="assets/images/avatars/avatar-3.jpg" alt="">
                                </span>
                                <span class="notification-icon bg-gradient-danger">
                                    <i class="icon-feather-star"></i></span>
                                <span class="notification-text">
                                    <strong>Alex Dolgove</strong> Added New Review In Video
                                    <span class="text-primary">Full Stack PHP Developer</span>
                                    <br> <span class="time-ago"> 19 hours ago </span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="assets/images/avatars/avatar-4.jpg" alt="">
                                </span>
                                <span class="notification-icon bg-gradient-success">
                                    <i class="icon-feather-message-circle"></i></span>
                                <span class="notification-text">
                                    <strong>Stella John</strong> Replay Your Comment in
                                    <span class="text-primary">Adobe XD Tutorial</span>
                                    <br> <span class="time-ago"> 12 hours ago </span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                </span>
                                <span class="notification-icon bg-gradient-primary">
                                    <i class="icon-feather-thumbs-up"></i></span>
                                <span class="notification-text">
                                    <strong>Adrian Moh.</strong> Like Your Comment On Video
                                    <span class="text-primary">Learn Prototype Faster</span>
                                    <br> <span class="time-ago"> 9 hours ago </span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="assets/images/avatars/avatar-3.jpg" alt="">
                                </span>
                                <span class="notification-icon bg-gradient-warning">
                                    <i class="icon-feather-star"></i></span>
                                <span class="notification-text">
                                    <strong>Alex Dolgove</strong> Added New Review In Video
                                    <span class="text-primary">Full Stack PHP Developer</span>
                                    <br> <span class="time-ago"> 19 hours ago </span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="notification-avatar">
                                    <img src="assets/images/avatars/avatar-4.jpg" alt="">
                                </span>
                                <span class="notification-icon bg-gradient-success">
                                    <i class="icon-feather-message-circle"></i></span>
                                <span class="notification-text">
                                    <strong>Stella John</strong> Replay Your Comment in
                                    <span class="text-primary">Adobe XD Tutorial</span>
                                    <br> <span class="time-ago"> 12 hours ago </span>
                                </span>
                            </a>
                        </li>
                    </ul>

                </div>

            </div>

            <!-- profile -image -->
            <a class="opts_account" href="#">
                <img src="{{asset('storage/'.Auth::user()->empl->avatar)}}" alt=""
                @if (Auth::user()->empl->gender == 'Pria')
                    onerror="this.src='{{asset('assets/admin/images/male.png')}}';"
                @endif 
                    onerror="this.src='{{asset('assets/admin/images/female.png')}}';">
            </a>

            <!-- profile dropdown-->
            <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small"
                class="dropdown-notifications rounded display-hidden">

                <!-- User Name / Avatar -->
                {{-- <a href="#"> --}}

                    <div class="dropdown-user-details">

                        <div class="dropdown-user-cover">
                            <img src="{{asset('storage/'.Auth::user()->empl->avatar)}}" alt=""
                            @if (Auth::user()->empl->gender == 'Pria')
                                onerror="this.src='{{asset('assets/admin/images/male.png')}}';"
                            @endif 
                                onerror="this.src='{{asset('assets/admin/images/female.png')}}';">
                        </div>
                        <div class="dropdown-user-avatar">
                            <img src="{{asset('storage/'.Auth::user()->empl->avatar)}}" alt=""
                            @if (Auth::user()->empl->gender == 'Pria')
                                onerror="this.src='{{asset('assets/admin/images/male.png')}}';"
                            @endif 
                                onerror="this.src='{{asset('assets/admin/images/female.png')}}';">
                        </div>
                        <div class="dropdown-user-name"> {{Auth::user()->empl->empl_name}} </div>
                        <div class="dropdown-user-division"> {{Auth::user()->empl->division->name}} </div>
                    </div>

                {{-- </a> --}}

                <ul class="dropdown-user-menu">
                    <li><a href="#"> <i class="fas fa-user-edit"></i> General Settings</a></li>
                    </li>
                    <li><a href="{{route('logout')}}"> <i class="fas fa-sign-out-alt"></i>Log Out</a>
                    </li>
                </ul>

            </div>

        </div>

    </div> 
</header>