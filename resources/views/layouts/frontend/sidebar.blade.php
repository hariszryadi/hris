<div class="side-overlay" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></div>

<!-- sidebar header -->
<div class="sidebar-header">
    <!-- Logo-->
    <div id="logo">
        <a href="#"> <img src="{{asset('images/logo.png')}}" alt=""></a>
    </div>
    <span class="btn-close" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"></span>
</div>
    
<!-- sidebar Menu -->
<div class="sidebar">
    <div class="sidebar_innr" data-simplebar>

        <div class="sections">
            <ul>
                <li class="{{request()->is('/') ? 'active' : ''}}">
                    <a href="{{route('dashboard')}}">
                        <i class="fa fa-home"></i>
                        Dashboard 
                    </a>
                </li>
                <li class="{{request()->is('leave') ? 'active' : ''}}">
                    <a href="{{route('leave')}}">
                        <i class="fa fa-calendar"></i> 
                        Cuti/Izin
                    </a>
                </li>
                <li class="{{request()->is('overtime') ? 'active' : ''}}">
                    <a href="{{route('overtime')}}">
                        <i class="fa fa-clock-o"></i> 
                        Lembur 
                    </a>
                </li>
            
            </ul>
        </div>
    
        <!--  Optional Footer -->
        <div id="foot">
    
            {{-- <ul>
                <li> <a href="#" uk-tooltip="title: About Us ; pos: bottom ;offset:7"> About Us </a></li>
                <li> <a href="#" uk-tooltip="title: Setting ; pos: bottom ;offset:7"> Setting </a></li>
                <li> <a href="#" uk-tooltip="title: Privacy Policy ; pos: bottom ;offset:7"> Privacy Policy </a></li>
                <li> <a href="#" uk-tooltip="title: Terms - Conditions ; pos: bottom ;offset:7"> Terms - Conditions </a></li>
            </ul> --}}
    
            <div class="foot-content">
                <p>© 2021 <strong>HRIS.TEDC</strong>. All Rights Reserved. </p>
            </div>
    
        </div>
    
    </div>
</div>