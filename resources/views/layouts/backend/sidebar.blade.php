<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"><img src="{{asset('assets/admin/images/placeholder.jpg')}}" class="img-circle img-sm" alt=""></a>
                    <div class="media-body">
                        <span class="media-heading text-semibold">{{Auth::user()->name}}</span>
                        <div class="text-size-mini text-muted">
                            {{Auth::user()->email}}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- /user menu -->
        
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span></span> <i class="icon-menu" title="Main pages"></i></li>
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="icon-home4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-cube3"></i>
                            <span>Master</span></a>
                        <ul>
                            <li class="nav-item {{request()->is('admin/division/*') ? 'active' : ''}}">
                                <a href="{{route('admin.division.index')}}">Divisi</a>
                            </li>
                
                            <li class="nav-item {{request()->is('admin/employee/*') ? 'active' : ''}}">
                                <a href="{{route('admin.employee.index')}}">Pegawai</a>
                            </li>
                
                        </ul>
                    </li>
                
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-transmission"></i>
                            <span>Transaction</span></a>
                        <ul>
                            <li class="nav-item">
                                <a href="#">Transaksi Lembur</a>
                            </li>

                            <li class="nav-item">
                                <a href="#">Transaksi Cuti</a>
                            </li>
                        </ul>
                    </li>
                
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-user-lock"></i>
                            <span>User Config</span></a>
                        <ul>
            
                            <li class="nav-item {{request()->is('admin/account/*') ? 'active' : ''}}">
                                <a href="{{route('admin.account.index')}}">Account Pegawai</a>
                            </li>

                            <li class="nav-item">
                                <a href="#">Role</a>
                            </li>

                            <li class="nav-item">
                                <a href="#">User Admin</a>
                            </li>
            
                        </ul>
                    </li>
                
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>